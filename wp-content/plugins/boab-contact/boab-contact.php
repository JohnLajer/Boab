<?php
/**
    Plugin Name:    Boab Basic Contact Module
    Version:        0.0.1
    Description:    Learning how to create plugins
    Author:         John Lajer
 */

add_action('admin_notices', 'boab_ContactActivated');
function boab_ContactActivated()
{
?>
    <div class="notice notice-success">
        <p>Yeah! basic contact plugin is active!</p>
    </div>
<?php
}


add_action('admin_menu', 'boab_AddMenu');
function boab_AddMenu()
{
    add_menu_page('Contact test', 'Contact test', 'manage_options', 'boab-contact', 'boabContact');
    add_submenu_page('boab-contact', 'Contact stuff', 'Contact stuff', 'manage_options', 'boab-contact-stuff', 'boabContactStuff');
}

function boabContact()
{
    $chk = '';
    if(!empty($_POST)) :
        $strText = $_POST['textytext'];

        if(get_option('texty_text') != trim($strText)) :

            $chk = update_option('texty_text', trim($strText));

        endif;

    endif;

    $strSuccess = '';
    if(!empty($_POST) && !empty($chk)) :
        $strSuccess = '
        <div id="message" class="updated below-h2">
            <p>SUCCESS</p>
        </div>
        ';
    endif;

    echo '
    <div class="wrap">
        <h2>Stuff</h2>
        '.$strSuccess.'
        <form method="post" action="">
            <input type="text" name="textytext" value="'.get_option('texty_text').'" />
            <input type="submit" value="submit" />
        </form>
    </div>
    ';
}
function boabContactStuff()
{
    echo 'SECRECY!!!';
}

function boab_Footer()
{
    echo '<div>'.get_option('texty_text').'</div>';
}
add_action('wp_footer', 'boab_Footer');
?>
