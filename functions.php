<?php
//DO NOT DELETE THIS. IT WILL CAUSE THE THEME WIDGETS NOT TO WORK PROPERLY
define("THEME_ASSIGNED_ID", "theme1"); //entered assigned ID without trailing slashes and spaces

// custom css for our meta boxes
if (is_admin()) wp_enqueue_style('custom_meta_css', get_bloginfo("template_directory") . '/css/meta.css');

/*
add tinymice for post content of seminar
*/
add_filter('admin_head', 'zd_multilang_tinymce');

/* ---------------------------------------------------------------------------- */
//Run initial setup for the theme
add_action('after_setup_theme', 'bm_admin_setup');

if (!function_exists('bmmi_setup')):
    function bm_admin_setup()
    {
        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');

    }
endif;

include("includes/resize.php");
include("includes/database.inc.php");
include("includes/database.update.inc.php");
include("includes/database.query.inc.php");
include("includes/photo_box.inc.php");

include("includes/mb_homepage.php");
include("includes/mb_homepage_footer.php");
include("includes/mb_insidepage.php");


$theme_foldername = basename(dirname(__FILE__));
/* INCLUDE CLASSES */
if (count(glob(get_theme_root() . "/" . $theme_foldername . "/classes/*"))) {
    foreach (glob(get_theme_root() . "/" . $theme_foldername . "/classes/*.class.php", GLOB_NOCHECK) as $filename) {
        include_once $filename;
    }
}

add_action('init', 'ilc_farbtastic_script');
function ilc_farbtastic_script()
{
    wp_enqueue_style('farbtastic');
    wp_enqueue_script('farbtastic');
}

/* ------------------------------------------------------------------------------------------------ */

function zd_multilang_tinymce()
{
    echo "<link rel='stylesheet' href='" . get_bloginfo('template_directory') . "/css/admin.css' type='text/css' media='screen' />\n";
    echo '<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />';

    wp_enqueue_script('common');
    wp_enqueue_script('jquery-color');
    wp_print_scripts('editor');
    if (function_exists('add_thickbox')) add_thickbox();
    wp_print_scripts('media-upload');
    wp_admin_css();
    wp_enqueue_script('utils');
    do_action("admin_print_styles-post-php");
    do_action('admin_print_styles');
    ?>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>


    <script>
        jQuery(function () {
            jQuery(".file_sortable").sortable({
                update: function (event, ui) {
                }
            });
        });

    </script>

    <script type="text/javascript">
        var keylist = "abcdefghijklmnopqrstuvwxyz123456789";
        var temp = '';
        var itm_id = 'wystest';
        function generatestr(plength) {
            temp = '';
            for (i = 0; i < plength; i++)
                temp += keylist.charAt(Math.floor(Math.random() * keylist.length));
            return temp;
        }

        function passrows(rowcount) {
            counter_row = rowcount;
            ctr_id = rowcount;

            jQuery('img.removerow').click(function () {
                counter_row -= (jQuery(this).closest('table').find('tr').length - 1);
                //counter_row--;
                jQuery(this).parent().parent().remove();
            });
        }

        function reset_Form(ele) {
            jQuery(ele).find(':input').each(function () {
                switch (this.type) {
                    case 'password':
                    case 'text':
                    case 'textarea':
                        jQuery(this).val('');
                        break;
                    case 'checkbox':
                    case 'radio':
                        this.checked = false;
                }
            });
        }
    </script>
<?php
}


function my_mce_buttons_2($buttons)
{
    /**
     * Add in a core button that's disabled by default
     */
    $buttons[] = 'superscript';
    return $buttons;
}

add_filter('mce_buttons_2', 'my_mce_buttons_2');

add_action('in_admin_footer', 'foot_monger');

function foot_monger()
{ ?>

    <script type='text/javascript'>
        jQuery(document).ready(function ($) {
            var _custom_media = true,
                _orig_send_attachment = wp.media.editor.send.attachment;

            $('.uploader .button').click(function (e) {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                var button = $(this);
                var id = button.attr('id').replace('_button', '');
                _custom_media = true;
                wp.media.editor.send.attachment = function (props, attachment) {
                    if (_custom_media) {
                        $("#" + id).val(attachment.url);
                        $("#" + id).prev().attr('src', $("#" + id).val());
                    } else {
                        return _orig_send_attachment.apply(this, [props, attachment]);

                    }
                    ;
                }

                wp.media.editor.open(button);
                return false;
            });

            $('.add_media').on('click', function () {
                _custom_media = false;
            });
        });</script>
    <?php
}

add_action('admin_enqueue_scripts', 'im_add_color_picker');
function im_add_color_picker()
{
    if (is_admin()) {
        // Add the color picker css file
        wp_enqueue_style('wp-color-picker');

        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script('custom-script-handle', get_template_directory_uri() . '/js/admin-scripts.js', array('wp-color-picker'), false, true);
    }
}