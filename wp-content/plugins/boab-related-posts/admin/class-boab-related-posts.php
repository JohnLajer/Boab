<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://boabdesign.com.au
 * @since      0.1.0
 *
 * @package    Boab_Related_Posts
 * @subpackage Boab_Related_Posts/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, the meta box functionality
 * and the JavaScript for loading the Media Uploader.
 *
 * @package    Boab_Related_Posts
 * @subpackage Boab_Related_Posts/admin
 * @author     John Lajer <john@thinktall.com.au>
 */
class Boab_Related_posts {

    /**
     * The ID of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $name    The ID of this plugin.
     */
    private $name;

    /**
     * The current version of the plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $version    The version of the plugin
     */
    private $version;

    /**
     * Initializes the plugin by defining the properties.
     *
     * @since 0.1.0
     */
    public function __construct() {

        $this->name = 'boab-related-posts';
        $this->version = '0.1.0';

    }

    /**
     * Defines the hooks that will register and enqueue the JavaScript
     * and the meta box that will render the option.
     *
     * @since 0.1.0
     */
    public function run() {

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

        add_action( 'wp_ajax_search_related_content', array( $this, 'get_related_posts_ajax' ) );

        add_action( 'save_post', array( $this, 'save_post' ) );

    }

    /**
     * Renders the meta box on the post and pages.
     *
     * @since 0.1.0
     */
    public function add_meta_box() {

        $screens = array( 'post', 'boab_project' );

        foreach ( $screens as $screen ) {

            add_meta_box(
                $this->name,
                'Boab Related Posts',
                array( $this, 'display_related_posts_selector' ),
                $screen,
                'normal'
            );

        }

    }

    /**
     * Registers the stylesheets for handling the meta box
     *
     * @since 0.2.0
     */
    public function enqueue_styles() {

        wp_enqueue_style(
            $this->name,
            plugin_dir_url( __FILE__ ) . 'css/admin.css',
            array()
        );


    }

    /**
     * Registers the JavaScript for handling the media uploader.
     *
     * @since 0.1.0
     */
    public function enqueue_scripts() {

        wp_enqueue_media();

        wp_enqueue_script(
            $this->name,
            plugin_dir_url( __FILE__ ) . 'js/admin.js',
            array( 'jquery' ),
            $this->version,
            'all'
        );

    }

    public function get_related_posts_ajax()
    {
        wp_send_json_success(
            $this->get_related_posts_options(
                esc_attr($_POST['posttype']),
                esc_attr($_POST['search'])
            )
        );

        wp_die();
    }

    public function get_related_posts_options($strPostType, $strSearch = '')
    {
        global $wpdb;

        $strSearchCondition = !empty($strSearch) ? '&& p.post_title LIKE "%'.$strSearch.'%"' : '';

        $arrResults = $wpdb->get_results("
          SELECT
            p.* 
          FROM
            {$wpdb->posts} p 
          WHERE
            p.post_type = '".$strPostType."'
            && p.post_status = 'publish'
            ".$strSearchCondition."
          ORDER BY
            p.id DESC
          LIMIT 20
        ");

        $strResults = '';
        foreach($arrResults as $oResult)
        {
            $strResults .= $this->render_related_posts($oResult);
        }

        return $strResults;
    }

    public function render_related_posts($oResult)
    {
        $arrThumb = wp_get_attachment_image_src(get_post_thumbnail_id($oResult), 'thumbnail', true);
        $arrTrueSizeImg = wp_get_attachment_image_src(get_post_thumbnail_id($oResult), 'medium');

        $strFeaturedImage = $arrThumb[0] != 'http://vccw.dev/WeAreBoab/wp-includes/images/media/default.png' ?
            '<img src="'.$arrThumb[0].'" data-imageurl="'.$arrTrueSizeImg[0].'" data-post-id="'.$oResult->ID.'" data-post-title="'.$oResult->post_title.'"/>'
          : '<img src="'.plugin_dir_url( __FILE__ ).'img/no-image-available.jpg" data-imageurl="'.plugin_dir_url( __FILE__ ).'img/no-image-available.jpg" data-post-id="'.$oResult->ID.'" data-post-title="'.$oResult->post_title.'" />';


        return '
            <div class="related-post">
                <div class="related-post-overlay"><span class="hidden">Choose Post</span></div>
                <div class="related-post-viewer">
                    '.$strFeaturedImage.'<br />
                    <span>'.$oResult->post_title.'</span>
                </div>
            </div>
        ';
    }

    /**
     * Sanitized and saves the post featured image meta data specific with this post.
     *
     * @param    int    $post_id    The ID of the post with which we're currently working.
     * @since 0.2.0
     */
    public function save_post( $post_id ) {

        # Related post 1
        if ( isset( $_REQUEST['related-post-id-1-post-id'] ) ) {
            update_post_meta( $post_id, 'related-post-id-1-post-id', sanitize_text_field( $_REQUEST['related-post-id-1-post-id'] ) );
        }

        # Related post 2
        if ( isset( $_REQUEST['related-post-id-2-post-id'] ) ) {
            update_post_meta( $post_id, 'related-post-id-2-post-id', sanitize_text_field( $_REQUEST['related-post-id-2-post-id'] ) );
        }

        # Related post 3
        if ( isset( $_REQUEST['related-post-id-3-post-id'] ) ) {
            update_post_meta( $post_id, 'related-post-id-3-post-id', sanitize_text_field( $_REQUEST['related-post-id-3-post-id'] ) );
        }
    }

    /**
     * Renders the view that displays the contents for the meta box that for triggering
     * the meta box.
     *
     * @param    WP_Post    $post    The post object
     * @since    0.1.0
     */
    public function display_related_posts_selector( $post ) {

        $strRelatedPost1ImgSrc = '';
        $strRelatedPost2ImgSrc = '';
        $strRelatedPost3ImgSrc = '';

        if($post->ID > 0) {
            $strRelatedPost1ID = isset(get_post_meta($post->ID, 'related-post-id-1-post-id')[0]) ? intval(get_post_meta($post->ID, 'related-post-id-1-post-id')[0]) : '';
            $strRelatedPost2ID = isset(get_post_meta($post->ID, 'related-post-id-2-post-id')[0]) ? intval(get_post_meta($post->ID, 'related-post-id-2-post-id')[0]) : '';
            $strRelatedPost3ID = isset(get_post_meta($post->ID, 'related-post-id-3-post-id')[0]) ? intval(get_post_meta($post->ID, 'related-post-id-3-post-id')[0]) : '';

            $strRelatedPost1ImgSrc = wp_get_attachment_image_src(get_post_thumbnail_id($strRelatedPost1ID), 'medium')[0];
            $strRelatedPost2ImgSrc = wp_get_attachment_image_src(get_post_thumbnail_id($strRelatedPost2ID), 'medium')[0];
            $strRelatedPost3ImgSrc = wp_get_attachment_image_src(get_post_thumbnail_id($strRelatedPost3ID), 'medium')[0];

            $strRelatedPost1ImgSrc = is_null($strRelatedPost1ImgSrc) ? plugin_dir_url(__FILE__) . 'img/no-image-available.jpg' : $strRelatedPost1ImgSrc;
            $strRelatedPost2ImgSrc = is_null($strRelatedPost2ImgSrc) ? plugin_dir_url(__FILE__) . 'img/no-image-available.jpg' : $strRelatedPost2ImgSrc;
            $strRelatedPost3ImgSrc = is_null($strRelatedPost3ImgSrc) ? plugin_dir_url(__FILE__) . 'img/no-image-available.jpg' : $strRelatedPost3ImgSrc;
        }

        echo '
        If you do not select any related posts, the site will dynamically choose posts it deems related (Hint: You\'re probably better at making those decisions than a computer. However, if you don\'t select any related posts, the related posts will always be some of the newer posts)
        <table border="0" cellspacing="0" cellpadding="6" class="related-posts-finder" data-posttype="'.get_post_type().'">
        <tr>
            <td>
                <div class="related-post-button">
                    <input type="button" value="Add Related Post" id="related-post-id-1"/>
                </div>
                <div class="chosen-related-post hidden">
                    <div>
                        <img src="" />
                        <div></div>
                    </div>
                    <a title="Remove Related Post" href="javascript:void(0);" >Remove Related Post</a>
                </div>
                <div class="info-container hidden">
                    <input type="text" value="'.$strRelatedPost1ID.'" name="related-post-id-1-post-id" id="related-post-id-1-post-id" data-img-src="'.$strRelatedPost1ImgSrc.'" data-post-title="'.get_the_title($strRelatedPost1ID).'" />
                </div>
            </td>
            <td>
                <div class="related-post-button">
                    <input type="button" value="Add Related Post" id="related-post-id-2"/>
                </div>
                <div class="chosen-related-post hidden">
                    <div>
                        <img src="" />
                        <div></div>
                    </div>
                    <a title="Remove Related Post" href="javascript:void(0);" >Remove Related Post</a>
                </div>
                <div class="info-container hidden">
                    <input type="text" value="'.$strRelatedPost2ID.'" name="related-post-id-2-post-id" id="related-post-id-2-post-id" data-img-src="'.$strRelatedPost2ImgSrc.'" data-post-title="'.get_the_title($strRelatedPost2ID).'" />
                </div>
            </td>
            <td>
                <div class="related-post-button">
                    <input type="button" value="Add Related Post" id="related-post-id-3"/>
                </div>
                <div class="chosen-related-post hidden">
                    <div>
                        <img src="" />
                        <div></div>
                    </div>
                    <a title="Remove Related Post" href="javascript:void(0);" >Remove Related Post</a>
                </div>
                <div class="info-container hidden">
                    <input type="text" value="'.$strRelatedPost3ID.'" name="related-post-id-3-post-id" id="related-post-id-3-post-id" data-img-src="'.$strRelatedPost3ImgSrc.'" data-post-title="'.get_the_title($strRelatedPost3ID).'" />
                </div>
            </td>
        </tr>
        </table>
        <div id="related-post-chooser">
            <div id="related-post-search"><input type="text" name="related-post-name" value="" placeholder="Start Typing Post Name"/></div>
            <div id="related-posts-results">
                '.$this->get_related_posts_options(get_post_type()).'
            </div>
        </div>
        <div class="clear"></div>
        ';
    }

}