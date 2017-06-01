<?php

/**
 * Setup current context on front-end carousel with certain settings.
 *
 * @link       http://boabdesign.com.au
 * @since      0.1.0
 *
 * @package    Boab_Carousel_Settings
 * @subpackage Boab_Carousel_Settings/admin
 */

/**
 * Setup current context on front-end carousel with certain settings.
 *
 * Defines the plugin name, version, the meta box functionality
 * and the JavaScript for loading the Media Uploader.
 *
 * @package    Boab_Carousel_Settings
 * @subpackage Boab_Carousel_Settings/admin
 * @author     John Lajer <john@thinktall.com.au>
 */
class Boab_Carousel_Settings {

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

        $this->name = 'boab-carousel-settings';
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

        add_action( 'save_post', array( $this, 'save_post' ) );
    }

    /**
     * Renders the meta box on the post and pages.
     *
     * @since 0.1.0
     */
    public function add_meta_box() {

        $screens = array( 'post', 'boab_project'  );

        foreach ( $screens as $screen ) {

            add_meta_box(
                $this->name,
                'Carousel Settings',
                array( $this, 'boab_carousel_settings' ),
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

        wp_enqueue_script(
            $this->name.'-js-color',
            plugin_dir_url( __FILE__ ) . 'libs/jscolor/jscolor.min.js',
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
     * Sanitized and saves the post featured image meta data specific with this post.
     *
     * @param    int    $post_id    The ID of the post with which we're currently working.
     * @since 0.2.0
     */
    public function save_post( $post_id ) {

        # Use in Carousel
        $iUseInCarousel = isset($_POST['carousel-use-in-carousel']) ? 1 : 0;

        update_post_meta( $post_id, '_boab_carousel_use_in_carousel', $iUseInCarousel );

        // Only go further if we're saving carousel data
        if($iUseInCarousel == 1) {
            // Get all entries in post that starts with carousel
            $arrCarouselSettings = [];
            foreach ($_POST as $key => $value) {

                // Don't count the one named 'carousel-use-in-carousel', that one is handles manually
                if ($key == 'carousel-use-in-carousel')
                    continue;

                $expKey = explode('-', $key);
                if ($expKey[0] == 'carousel') {
                    $arrCarouselSettings[$key] = sanitize_text_field($value);
                }
            }

            if (count($arrCarouselSettings) > 0) {
                $strCarouselSettings = json_encode($arrCarouselSettings);

                update_post_meta($post_id, '_boab_carousel_settings', $strCarouselSettings);
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
    public function boab_carousel_settings( $post ) {


        // Default settings
        $iIsCarouselCandidate = get_post_meta($post->ID, '_boab_carousel_use_in_carousel', true);

        $strHeadline            = $post->post_title;
        $strSubHeadlineSelect   = get_current_screen()->id == 'post' ? 'date' : 'none';
        $strSubHeadline         = '';
        $strGraphics            = get_current_screen()->id == 'post' ? 'icon' : 'featured-image';
        $strBackgroundColor     = 'F5F0E8';

        # Images
        $strImageSrc            = '';
        $strImageTitle          = '';
        $strImageAlt            = '';

        $strIconSrc             = plugins_url( '/img/bulb-icon.png', __FILE__ );
        $strIconTitle           = 'Light Bulb';
        $strIconAlt             = 'Light Bulb';

        // Use meta data instead of default data is it's set in the database
        $strMetaDataJson = get_post_meta($post->ID, '_boab_carousel_settings', true);

        if(!empty($strMetaDataJson))
        {
            $oMetaData = json_decode($strMetaDataJson);

            $strHeadline            = $oMetaData->{'carousel-headline'};
            $strSubHeadlineSelect   = $oMetaData->{'carousel-sub-headline'};
            $strSubHeadline         = $oMetaData->{'carousel-custom-sub-headline'};
            $strGraphics            = $oMetaData->{'carousel-graphics'};
            $strBackgroundColor     = $oMetaData->{'carousel-custom-background-color'};

            # Images
            $strImageSrc            = $oMetaData->{'carousel-graphics-custom-image-src'};
            $strImageTitle          = $oMetaData->{'carousel-graphics-custom-image-title'};
            $strImageAlt            = $oMetaData->{'carousel-graphics-custom-image-alt'};

            $strIconSrc             = $oMetaData->{'carousel-graphics-custom-icon-src'};
            $strIconTitle           = $oMetaData->{'carousel-graphics-custom-icon-title'};
            $strIconAlt             = $oMetaData->{'carousel-graphics-custom-icon-alt'};;
        }

        echo '
        <label>
            <input type="checkbox" name="carousel-use-in-carousel" id="carousel-use-in-carousel" value="1" '.($iIsCarouselCandidate == 1 ? 'checked' : '').' />
            Use this post on the frontpage carousel
        </label>
        <div id="carousel-options" class="hidden">
            <table border="0" cellspacing="0" cellpadding="6">
            <tr>
                <td><label for="carousel-headline">Headline:</td>
                <td colspan="2"><input type="text" name="carousel-headline" id="carousel-headline" value="'.$strHeadline.'" placeholder="Splash text on carousel image" /></td>
            </tr>
            <tr>
                <td><label for="carousel-sub-headline">Sub-Headline:</td>
                <td colspan="2">
                    <select name="carousel-sub-headline" id="carousel-sub-headline">
                        <option value="none" '.($strSubHeadlineSelect == 'none' ? 'selected' : '').'>-- None --</option>
                        <option value="custom-text" '.($strSubHeadlineSelect == 'custom-text' ? 'selected' : '').'>Custom text</option>
                        <option value="date" '.($strSubHeadlineSelect == 'date' ? 'selected' : '').'>Published date</option>
                    </select>
                </td>
            </tr>
            <tr id="carousel-custom-sub-headline-row">
                <td><label for="carousel-custom-sub-headline">Custom Sub-Headline:</td>
                <td colspan="2"><input type="text" name="carousel-custom-sub-headline" id="carousel-custom-sub-headline" value="'.$strSubHeadline.'" placeholder="Please type custom sub-headline" /></td>
            </tr>
            <tr>
                <td><label>Graphics:</td>
                <td colspan="2">
                    <select name="carousel-graphics" id="carousel-graphics">
                        <option value="none" '.($strGraphics == 'none' ? 'selected' : '').'>-- None --</option>
                        <option value="featured-image" '.($strGraphics == 'featured-image' ? 'selected' : '').'>Same as featured image</option>
                        <option value="custom-image" '.($strGraphics == 'custom-image' ? 'selected' : '').'>Custom image</option>
                        <option value="icon" '.($strGraphics == 'icon' ? 'selected' : '').'>Icon</option>
                    </select>
                </td>
            </tr>
            <tr id="carousel-custom-background-color-row" class="carousel-graphics-row">
                <td><label for="carousel-custom-background-color">Background Color:</td>
                <td><input type="text" name="carousel-custom-background-color" id="carousel-custom-background-color" class="jscolor" value="'.$strBackgroundColor.'" maxlength="6" placeholder="Please choose a background color" /></td>
                <td><a href="javascript:void(0);" id="default-background-color">Default</a></td>
            </tr>
            <tr id="carousel-graphics-custom-image-row" class="carousel-graphics-row">
                <td><label for="carousel-graphics-custom-image">Choose image</td>
                <td colspan="2">
                    <div class="image hidden">
                        <img src="" alt="" title="" />
                        <a title="Remove custom image" href="javascript:void(0);" class="remove-img" data-no="1">Remove</a>
                    </div>
                    <div class="set-button">
                        <input type="button" name="carousel-graphics-custom-image" id="carousel-graphics-custom-image" class="add-custom-graphics" value="Choose custom image" />
                    </div>
                    <div class="image-values hidden">
                        <input type="text" value="'.$strImageSrc.'" name="carousel-graphics-custom-image-src" id="carousel-graphics-custom-image-src" class="carousel-graphics-custom-src" />
                        <input type="text" value="'.$strImageAlt.'" name="carousel-graphics-custom-image-alt" id="carousel-graphics-custom-image-alt" class="carousel-graphics-custom-alt" />
                        <input type="text" value="'.$strImageTitle.'" name="carousel-graphics-custom-image-title" id="carousel-graphics-custom-image-title" class="carousel-graphics-custom-title" />
                    </div>
                </td>
            </tr>
            <tr id="carousel-graphics-custom-icon-row" class="carousel-graphics-row">
                <td><label for="carousel-graphics-custom-icon">Choose icon</td>
                <td colspan="2">
                    <div class="image hidden">
                        <img src="" alt="" title="" />
                        <a title="Remove custom icon" href="javascript:void(0);" class="remove-img" data-no="1">Remove</a>
                    </div>
                    <div class="set-button">
                        <input type="button" name="carousel-graphics-custom-icon" id="carousel-graphics-custom-icon" class="add-custom-graphics" value="Choose custom icon" />
                    </div>
                    <div class="image-values hidden">
                        <input type="text" value="'.$strIconSrc.'" name="carousel-graphics-custom-icon-src" id="carousel-graphics-custom-icon-src" class="carousel-graphics-custom-src" />
                        <input type="text" value="'.$strIconAlt.'" name="carousel-graphics-custom-icon-alt" id="carousel-graphics-custom-icon-alt" class="carousel-graphics-custom-alt" />
                        <input type="text" value="'.$strIconTitle.'" name="carousel-graphics-custom-icon-title" id="carousel-graphics-custom-icon-title" class="carousel-graphics-custom-title" />
                    </div>
                </td>
            </tr>
            </table>
        </div>
        ';
    }

}