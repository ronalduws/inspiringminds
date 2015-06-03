<?php
/*************************************************
 * Homepage Bottom Content  Meta box
 ***************************************************/

add_action('admin_menu', 'create_bottom_content_meta_box');
add_action('save_post', 'save_post_bottom_content');

function create_bottom_content_meta_box()
{
    $template = get_post_meta($_REQUEST['post'], '_wp_page_template', true);
    if ($template === 'home.php') {
        add_meta_box('post_bottom_content_include', 'Bottom Content', 'post_bottom_content_include', 'page', 'normal', 'low');
    }
}

function post_bottom_content_include()
{
    $contentaddbottom = "";

    if (isset($_REQUEST['post'])) {
        $contentaddbottom = get_post_meta($_REQUEST['post'], 'contentaddbottom', true);
    }
    ?>

    <div class="event-date">
        <?php
        $id = 'contentaddbottom';
        $settings = array(
            'tinymce' => true,
        );
        wp_editor($contentaddbottom, $id, $settings);
        ?>
    </div>
<?php
}

function save_post_bottom_content()
{
    global $post;

    $contentaddbottom = $_POST['contentaddbottom'];
    $contentaddbottom = apply_filters('the_content', $contentaddbottom);
    $contentaddbottom = str_replace(']]>', ']]>', $contentaddbottom);

    update_post_meta($post->ID, 'contentaddbottom', $contentaddbottom);
}
