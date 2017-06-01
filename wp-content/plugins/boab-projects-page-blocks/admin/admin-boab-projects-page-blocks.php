<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://boabdesign.com.au
 * @since      0.1.0
 *
 * @package    Boab_Projects_Page_Blocks
 * @subpackage Boab_Projects_Page_Blocks/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, the meta box functionality
 * and the JavaScript for loading the Media Uploader.
 *
 * @package    Boab_Projects_Page_Blocks
 * @subpackage Boab_Projects_Page_Blocks/admin
 * @author     John Lajer <john@thinktall.com.au>
 */
class Boab_Projects_Page_Blocks {

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
     * Keeps count on how many blocks of content has been added, this value will serve as a provider of a unique ID.
     *
     * @since    0.1.0
     * @access   private
     * @var      int    $version    The version of the plugin
     */
    private $blockNo;

    /**
     * Initializes the plugin by defining the properties.
     *
     * @since 0.1.0
     */
    public function __construct() {

        $this->name = 'boab-projects-page-blocks';
        $this->version = '0.1.0';
        $this->blockNo = 0;

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
        add_action( 'wp_ajax_add_content_block', array( $this, 'add_content_block' ) );

        add_action( 'save_post', array( $this, 'save_post' ) );

    }

    /**
     * Renders the meta box on the post and pages.
     *
     * @since 0.1.0
     */
    public function add_meta_box() {

        $screens = array( 'boab_project' );

        foreach ( $screens as $screen ) {

            add_meta_box(
                $this->name,
                'Boab Projects Page Blocks',
                array( $this, 'display_boab_projects_page_blocks' ),
                $screen,
                'normal'
            );

        }

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
        wp_enqueue_script(
            $this->name.'-media-upload-control',
            plugin_dir_url( __FILE__ ) . 'js/media-upload-control.js',
            array( 'jquery' ),
            $this->version,
            'all'
        );

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
    * Add a content block to the page(project)
    *
    * @since 0.2.0
    */
    public function add_content_block()
    {
        // Keep up to date with the amount of boxes
        $this->blockNo = intval($_REQUEST['block_no']);
        wp_send_json_success(
            $this->add_content_block_type(
                esc_attr($_REQUEST['type'])
            )
        );

        wp_die();
    }

    /**
     * Extention of the add_content_block
     */
    function add_content_block_type($strType, $oData)
    {
        // Set some values, might differ if we're updating existing block or creating new

        $oValues = new stdClass();

        $oValues->strHeadline        = !isset($oData->headline) ? ucfirst($strType) : $oData->headline;
        $oValues->strText            = !isset($oData->text) ? '' : $oData->text;
        $oValues->strPhotographer    = !isset($oData->photographer) ? '' : $oData->photographer;

        # Image 1
        $oValues->strImg1Src         = !isset($oData->{'img-1-thumbnail-src'}) ? '' : $oData->{'img-1-thumbnail-src'};
        $oValues->strImg1Title       = !isset($oData->{'img-1-thumbnail-title'}) ? '' : $oData->{'img-1-thumbnail-title'};
        $oValues->strImg1Alt         = !isset($oData->{'img-1-thumbnail-alt'}) ? '' : $oData->{'img-1-thumbnail-alt'};

        # Image 2
        $oValues->strImg2Src         = !isset($oData->{'img-2-thumbnail-src'}) ? '' : $oData->{'img-2-thumbnail-src'};
        $oValues->strImg2Title       = !isset($oData->{'img-2-thumbnail-title'}) ? '' : $oData->{'img-2-thumbnail-title'};
        $oValues->strImg2Alt         = !isset($oData->{'img-2-thumbnail-alt'}) ? '' : $oData->{'img-2-thumbnail-alt'};

        # Image 3
        $oValues->strImg3Src         = !isset($oData->{'img-3-thumbnail-src'}) ? '' : $oData->{'img-3-thumbnail-src'};
        $oValues->strImg3Title       = !isset($oData->{'img-3-thumbnail-title'}) ? '' : $oData->{'img-3-thumbnail-title'};
        $oValues->strImg3Alt         = !isset($oData->{'img-3-thumbnail-alt'}) ? '' : $oData->{'img-3-thumbnail-alt'};

        # Image 4
        $oValues->strImg4Src         = !isset($oData->{'img-4-thumbnail-src'}) ? '' : $oData->{'img-4-thumbnail-src'};
        $oValues->strImg4Title       = !isset($oData->{'img-4-thumbnail-title'}) ? '' : $oData->{'img-4-thumbnail-title'};
        $oValues->strImg4Alt         = !isset($oData->{'img-4-thumbnail-alt'}) ? '' : $oData->{'img-4-thumbnail-alt'};

        # Image 5
        $oValues->strImg5Src         = !isset($oData->{'img-5-thumbnail-src'}) ? '' : $oData->{'img-5-thumbnail-src'};
        $oValues->strImg5Title       = !isset($oData->{'img-5-thumbnail-title'}) ? '' : $oData->{'img-5-thumbnail-title'};
        $oValues->strImg5Alt         = !isset($oData->{'img-5-thumbnail-alt'}) ? '' : $oData->{'img-5-thumbnail-alt'};

        # Image 6
        $oValues->strImg6Src         = !isset($oData->{'img-6-thumbnail-src'}) ? '' : $oData->{'img-6-thumbnail-src'};
        $oValues->strImg6Title       = !isset($oData->{'img-6-thumbnail-title'}) ? '' : $oData->{'img-6-thumbnail-title'};
        $oValues->strImg6Alt         = !isset($oData->{'img-6-thumbnail-alt'}) ? '' : $oData->{'img-6-thumbnail-alt'};

        $strRenderBlockContent = '';
        if($strType == 'gallery')
        {
            $strRenderBlockContent = $this->RenderGalleryBlockContent($oValues);
        }
        elseif($strType == '3-img-content')
        {
            $strRenderBlockContent = $this->Render3ImgBlockContent($oValues);
        }
        elseif($strType == '4-img-content')
        {
            $strRenderBlockContent = $this->Render4ImgBlockContent($oValues);
        }
        elseif($strType == 'divider-image')
        {
            $strRenderBlockContent = $this->RenderDividerImage($oValues);
        }

        return '
        <div class="group">
            <h3>
                <a href="javascript:void(0)">Delete</a>
                <label>'.ucfirst($strType).' Headline <input type="text" name="content-block['.$this->blockNo.'][headline]" value="'.$oValues->strHeadline.'" placeholder="Headline" /></label>
            </h3>
            <div class="block-container" data-block-no="'.$this->blockNo.'">
                <input type="hidden" name="content-block['.$this->blockNo.'][no]" value="'.$this->blockNo.'" />
                <input type="hidden" name="content-block['.$this->blockNo.'][type]" value="'.$strType.'" />
                '.$strRenderBlockContent.'
                <!-- Hidden elements that makes up the actual content, there is gonna be a lot -->
                <div id="content-holder-blockno-'.$this->blockNo.'" class="hidden">
                
                    <input type="text" id="img-1-blockno-'.$this->blockNo.'-thumbnail-src" name="content-block['.$this->blockNo.'][img-1-thumbnail-src]" value="'.$oValues->strImg1Src.'" />
                    <input type="text" id="img-1-blockno-'.$this->blockNo.'-thumbnail-title" name="content-block['.$this->blockNo.'][img-1-thumbnail-title]" value="'.$oValues->strImg1Title.'" />
                    <input type="text" id="img-1-blockno-'.$this->blockNo.'-thumbnail-alt" name="content-block['.$this->blockNo.'][img-1-thumbnail-alt]" value="'.$oValues->strImg1Alt.'" />
                    
                    <input type="text" id="img-2-blockno-'.$this->blockNo.'-thumbnail-src" name="content-block['.$this->blockNo.'][img-2-thumbnail-src]" value="'.$oValues->strImg2Src.'" />
                    <input type="text" id="img-2-blockno-'.$this->blockNo.'-thumbnail-title" name="content-block['.$this->blockNo.'][img-2-thumbnail-title]" value="'.$oValues->strImg2Title.'" />
                    <input type="text" id="img-2-blockno-'.$this->blockNo.'-thumbnail-alt" name="content-block['.$this->blockNo.'][img-2-thumbnail-alt]" value="'.$oValues->strImg2Alt.'" />
                    
                    <input type="text" id="img-3-blockno-'.$this->blockNo.'-thumbnail-src" name="content-block['.$this->blockNo.'][img-3-thumbnail-src]" value="'.$oValues->strImg3Src.'" />
                    <input type="text" id="img-3-blockno-'.$this->blockNo.'-thumbnail-title" name="content-block['.$this->blockNo.'][img-3-thumbnail-title]" value="'.$oValues->strImg3Title.'" />
                    <input type="text" id="img-3-blockno-'.$this->blockNo.'-thumbnail-alt" name="content-block['.$this->blockNo.'][img-3-thumbnail-alt]" value="'.$oValues->strImg3Alt.'" />
                    
                    <input type="text" id="img-4-blockno-'.$this->blockNo.'-thumbnail-src" name="content-block['.$this->blockNo.'][img-4-thumbnail-src]]" value="'.$oValues->strImg4Src.'" />
                    <input type="text" id="img-4-blockno-'.$this->blockNo.'-thumbnail-title" name="content-block['.$this->blockNo.'][img-4-thumbnail-title]" value="'.$oValues->strImg4Title.'" />
                    <input type="text" id="img-4-blockno-'.$this->blockNo.'-thumbnail-alt" name="content-block['.$this->blockNo.'][img-4-thumbnail-alt]" value="'.$oValues->strImg4Alt.'" />
                    
                    <input type="text" id="img-5-blockno-'.$this->blockNo.'-thumbnail-src" name="content-block['.$this->blockNo.'][img-5-thumbnail-src]" value="'.$oValues->strImg5Src.'" />
                    <input type="text" id="img-5-blockno-'.$this->blockNo.'-thumbnail-title" name="content-block['.$this->blockNo.'][img-5-thumbnail-title]" value="'.$oValues->strImg5Title.'" />
                    <input type="text" id="img-5-blockno-'.$this->blockNo.'-thumbnail-alt" name="content-block['.$this->blockNo.'][img-5-thumbnail-alt]" value="'.$oValues->strImg5Alt.'" />
                    
                    <input type="text" id="img-6-blockno-'.$this->blockNo.'-thumbnail-src" name="content-block['.$this->blockNo.'][img-6-thumbnail-src]" value="'.$oValues->strImg6Src.'" />
                    <input type="text" id="img-6-blockno-'.$this->blockNo.'-thumbnail-title" name="content-block['.$this->blockNo.'][img-6-thumbnail-title]" value="'.$oValues->strImg6Title.'" />
                    <input type="text" id="img-6-blockno-'.$this->blockNo.'-thumbnail-alt" name="content-block['.$this->blockNo.'][img-6-thumbnail-alt]" value="'.$oValues->strImg6Alt.'" />
                   
                </div>
            </div>
        </div>
        ';
    }

    public function RenderGalleryBlockContent($oValues)
    {
        return '
            <table border="0" cellspacing="0" cellpadding="6">
            <tr>
                <td>
                    <label>
                        Text:<br />
                        <textarea name="content-block['.$this->blockNo.'][text]" placeholder="Please write project text" class="gallery-textarea">'.$oValues->strText.'</textarea>
                    </label>
                </td>
                <td>
                    <label>
                        Photographer:<br />
                        <input type="text" name="content-block['.$this->blockNo.'][photographer]" value="'.$oValues->strPhotographer.'" placeholder="Photographer" />
                    </label>
                    <table border="0" cellspacing="0" cellpadding="6" class="images gallery">
                    <tr>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-1]" data-no="1" class="set-image" value="Add Image 1" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg1Src.'" alt="'.$oValues->strImg1Alt.'" title="'.$oValues->strImg1Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="1">Remove</a>
                            </div>
                        </td>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-2]" data-no="2" class="set-image" value="Add Image 2" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg2Src.'" alt="'.$oValues->strImg2Alt.'" title="'.$oValues->strImg2Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="2">Remove</a>
                            </div>        
                        </td>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-3]" data-no="3" class="set-image" value="Add Image 3" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg3Src.'" alt="'.$oValues->strImg3Alt.'" title="'.$oValues->strImg3Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="3">Remove</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-4]" data-no="4" class="set-image" value="Add Image 4" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg4Src.'" alt="'.$oValues->strImg4Alt.'" title="'.$oValues->strImg4Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="4">Remove</a>
                            </div>        
                        </td>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-5]" data-no="5" class="set-image" value="Add Image 5" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg5Src.'" alt="'.$oValues->strImg5Alt.'" title="'.$oValues->strImg5Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="5">Remove</a>
                            </div>        
                        </td>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-6]" data-no="6" class="set-image" value="Add Image 6" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg6Src.'" alt="'.$oValues->strImg6Alt.'" title="'.$oValues->strImg6Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="6">Remove</a>
                            </div>             
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            </table>
        ';
    }

    public function Render3ImgBlockContent($oValues)
    {
        return '
            <table border="0" cellspacing="0" cellpadding="6">
            <tr>
                <td>
                    <label>
                        Text:<br />
                        <textarea name="content-block['.$this->blockNo.'][text]" placeholder="Please write project text" class="three-img-textarea">'.$oValues->strText.'</textarea>
                    </label>
                </td>
                <td>
                    <table border="0" cellspacing="0" cellpadding="6" class="images three-img">
                    <tr>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-1]" data-no="1" class="set-image" value="Add Image 1" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg1Src.'" alt="'.$oValues->strImg1Alt.'" title="'.$oValues->strImg1Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="1">Remove</a>
                            </div>
                        </td>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-2]" data-no="2" class="set-image" value="Add Image 2" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg2Src.'" alt="'.$oValues->strImg2Alt.'" title="'.$oValues->strImg2Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="2">Remove</a>
                            </div>        
                        </td>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-3]" data-no="3" class="set-image" value="Add Image 3" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg3Src.'" alt="'.$oValues->strImg3Alt.'" title="'.$oValues->strImg3Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="3">Remove</a>
                            </div>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            </table>
        ';
    }

    public function Render4ImgBlockContent($oValues)
    {
        return '
            <table border="0" cellspacing="0" cellpadding="6">
            <tr>
                <td>
                    <label>
                        Text:<br />
                        <textarea name="content-block['.$this->blockNo.'][text]" placeholder="Please write project text" class="four-img-textarea">'.$oValues->strText.'</textarea>
                    </label>
                </td>
                <td>
                    <table border="0" cellspacing="0" cellpadding="6" class="images four-img">
                    <tr>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-1]" data-no="1" class="set-image" value="Add Image 1" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg1Src.'" alt="'.$oValues->strImg1Alt.'" title="'.$oValues->strImg1Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="1">Remove</a>
                            </div>
                        </td>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-2]" data-no="2" class="set-image" value="Add Image 2" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg2Src.'" alt="'.$oValues->strImg2Alt.'" title="'.$oValues->strImg2Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="2">Remove</a>
                            </div>        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-3]" data-no="3" class="set-image" value="Add Image 3" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg3Src.'" alt="'.$oValues->strImg3Alt.'" title="'.$oValues->strImg3Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="3">Remove</a>
                            </div>        
                        </td>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-4]" data-no="4" class="set-image" value="Add Image 4" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg4Src.'" alt="'.$oValues->strImg4Alt.'" title="'.$oValues->strImg4Title.'" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="4">Remove</a>
                            </div>        
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            </table>
        ';
    }

    public function RenderDividerImage($oValues)
    {
        return '
            <table border="0" cellspacing="0" cellpadding="6">
            <tr>
                <td>
                    <table border="0" cellspacing="0" cellpadding="6" class="images divider-img">
                    <tr>
                        <td>
                            <div class="set-button">
                                <input type="button" name="content-block['.$this->blockNo.'][add-image-1]" data-no="1" class="set-image" value="Add Image 1" />
                            </div>
                            <div class="image hidden">
                                <img src="'.$oValues->strImg1Src.'" alt="'.$oValues->strImg1Alt.'" title="'.$oValues->strImg1Title.'" class="divider" />
                                <a title="Remove gallery image" href="javascript:void(0);" class="remove-img" data-no="1">Remove</a>
                            </div>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            </table>
        ';
    }

    /**
     * Sanitized and saves the post featured image meta data specific with this post.
     *
     * @param    int    $post_id    The ID of the post with which we're currently working.
     * @since 0.2.0
     */
    public function save_post( $post_id ) {

        # Save Client Name
        if ( isset( $_POST['boab_projects_contact_client'] ) ) {
            update_post_meta( $post_id, 'boab_projects_contact_client', sanitize_text_field( $_POST['boab_projects_contact_client'] ) );
        }

        if(isset($_POST['content-block'])) {
            // So, any type of content block will have a type, let's loop through the headlines and save all of that juicy data

            if(count($_POST['content-block']) > 0) {
                global $wpdb;
                // Delete all meta data we have attached to this post of the content_block type
                $arrResults = $wpdb->get_results("
                  SELECT
                    pm.meta_id 
                  FROM
                    {$wpdb->postmeta} pm
                  WHERE
                    pm.meta_key LIKE '_project_content_block%'
                    AND pm.post_id = {$post_id}
                ");

                if(count($arrResults) > 0)
                {
                    foreach ($arrResults as $oResult)
                    {
                        $wpdb->delete('wp_postmeta', array('meta_id' => $oResult->meta_id));
                    }
                }

                $iOrder = 0;
                foreach ($_POST['content-block'] as $iEntryNo => $arrContentBlock) {
                    // sanitize all fields
                    $arrSanitizedBlock = [];
                    foreach ($arrContentBlock as $strKey => $strValue) {
                        if (is_int($strValue))
                            $arrSanitizedBlock[$strKey] = intval($strValue);
                        else
                            $arrSanitizedBlock[$strKey] = sanitize_text_field($strValue);
                    }

                    $arrSanitizedBlock['order'] = $iOrder;


                    $strJSON = json_encode($arrSanitizedBlock);

                    add_post_meta($post_id, '_project_content_block_' . (intval($arrContentBlock['no'])), $strJSON);

                    $iOrder++;
                }
            }
        }
    }

    /**
     * Renders the view that displays the contents for the meta box that for triggering
     * the meta box.
     *
     * @param    WP_Post    $post    The post object
     * @since    0.1.0
     */
    public function display_boab_projects_page_blocks( $post ) {

        global $wpdb;

        $arrResults = $wpdb->get_results("
          SELECT
            pm.meta_value 
          FROM
            {$wpdb->postmeta} pm
          RIGHT JOIN
            {$wpdb->posts} p 
            ON
                  p.ID = pm.post_id
              AND p.post_type = 'boab_project'
          WHERE
            pm.meta_key LIKE '_project_content_block%'
            AND pm.post_id = {$post->ID}
        ");

        // Loop through all the relevant responses from the database and add them to the meta field

        $strContentBlocks = '';
        if(sizeof($arrResults) > 0) {
            $arrBlocks = [];
            foreach ($arrResults as $oResult) {
                $oData = json_decode($oResult->meta_value);

                $arrBlocks[$oData->order] = $oData;
            }

            // Sort by order (array key)
            ksort($arrBlocks);


            foreach ($arrBlocks as $oData) {

                $this->blockNo = $oData->no;

                $strContentBlocks .= $this->add_content_block_type($oData->type, $oData);
            }
        }


        echo '
        <table border="0" cellspacing="0" cellpadding="6">
        <tr>
            <td><label for="boab_projects_contact_client">Client name: </label></td>
            <td><input type="text" id="boab_projects_contact_client" name="boab_projects_contact_client" value="'.get_post_meta($post->ID, 'boab_projects_contact_client', true).'" class="full-width" placeholder="Client Name" /></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><label for="boab_projects_add_block">Add content block: </label></td>
            <td>
                <select id="boab_projects_add_block" class="full-width">
                    <option value="gallery">Gallery</option>
                    <option value="3-img-content">3 Image content area</option>
                    <option value="4-img-content">4 Image content area</option>
                    <option value="divider-image">Divider Image</option>
                </select>
            </td>
            <td><input type="button" id="boab_project_add_block_button" value="Add" /></td>
        </tr>
        </table>
        <div id="accordion">
        '.$strContentBlocks.'
        </div>
        ';
    }

}