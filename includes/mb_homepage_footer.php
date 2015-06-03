<?php
/*************************************************
 * Homepage Footer Content  Meta box
 ***************************************************/

add_action('admin_menu', 'create_homepage_footer_meta_box');
add_action('save_post', 'save_post_homepage_footer_content');

function create_homepage_footer_meta_box()
{
    $template = get_post_meta($_REQUEST['post'], '_wp_page_template', true);
    if ($template === 'home.php') {
        add_meta_box('post_homepage_footer_include', 'Footer Content', 'post_homepage_footer_include', 'page', 'normal', 'low');
    }
}

function post_homepage_footer_include()
{
    $footercontentleft = "";
    $footercontentright = "";
    $footercontentbottom = "";


    if (isset($_REQUEST['post'])) {
        $footercontentleft = get_post_meta($_REQUEST['post'], 'footercontentleft', true);
        $footercontentright = get_post_meta($_REQUEST['post'], 'footercontentright', true);
        $footercontentbottom = get_post_meta($_REQUEST['post'], 'footercontentbottom', true);
    }
    ?>

    <div id="footer-home-left">
        <p><strong>Footer Left Content</strong></p>
        <?php
        $id = 'footercontentleft';
        $settings = array(
            'tinymce' => true,

        );
        wp_editor($footercontentleft, $id, $settings);
        ?>
    </div>
    <div id="footer-home-right">
        <p><strong>Footer Right Content</strong></p>
        <?php
        $id = 'footercontentright';
        $settings = array(
            'tinymce' => true,

        );
        wp_editor($footercontentright, $id, $settings);
        ?>
    </div>

    <div  id="footer-home-bottom">
        <p><strong>Footer Bottom Content</strong></p>
        <?php
        $id = 'footercontentbottom';
        $settings = array(
            'tinymce' => true,
            'editor_height' => '100'
        );
        wp_editor($footercontentbottom, $id, $settings);
        ?>
    </div>

<?php
}

function save_post_homepage_footer_content()
{
    global $post;

    $footercontentleft = $_POST['footercontentleft'];
    $footercontentleft = apply_filters('the_content', $footercontentleft);
    $footercontentleft = str_replace(']]>', ']]>', $footercontentleft);

    $footercontentright = $_POST['footercontentright'];
    $footercontentright = apply_filters('the_content', $footercontentright);
    $footercontentright = str_replace(']]>', ']]>', $footercontentright);

    $footercontentbottom= $_POST['footercontentbottom'];
    $footercontentbottom = apply_filters('the_content', $footercontentbottom);
    $footercontentbottom = str_replace(']]>', ']]>', $footercontentbottom);

    update_post_meta($post->ID, 'footercontentleft', $footercontentleft);
    update_post_meta($post->ID, 'footercontentright', $footercontentright);
    update_post_meta($post->ID, 'footercontentbottom', $footercontentbottom);
}
