<?php

/*************************************************
 * Second Column Custom Meta box
 ***************************************************/

add_action('admin_menu', 'create_second_column_meta_box');
add_action('save_post', 'save_post_second_column');

function create_second_column_meta_box()
{
    $template = get_post_meta($_REQUEST['post'], '_wp_page_template', true);

    if ($template !== 'home.php') {
        add_meta_box('post_second_column_include', 'Additional Contents and Settings', 'post_second_column_include', 'page', 'normal', 'high');
    }
}

function post_second_column_include()
{
    $textbg_color = "";
    $eventdates = "";

    $upload_image = "";
    $upload_image2 = "";
    $upload_image3 = "";
    $upload_image4 = "";

    $contentaddfirst = "";
    $contentaddtwo = "";
    $contentaddthird = "";
    $contentaddfourth = "";
    $check1 = "";
    $check2 = "";
    $check3 = "";
    $check4 = "";

    if (isset($_REQUEST['post'])) {
        $eventdates = get_post_meta($_REQUEST['post'], 'eventdates', true);
        $textbg_color = get_post_meta($_REQUEST['post'], 'textbg_color', true);

        $upload_image = get_post_meta($_REQUEST['post'], 'upload_image', true);
        $upload_image2 = get_post_meta($_REQUEST['post'], 'upload_image2', true);
        $upload_image3 = get_post_meta($_REQUEST['post'], 'upload_image3', true);
        $upload_image4 = get_post_meta($_REQUEST['post'], 'upload_image4', true);

        $contentaddfirst = get_post_meta($_REQUEST['post'], 'contentaddfirst', true);
        $contentaddtwo = get_post_meta($_REQUEST['post'], 'contentaddtwo', true);
        $contentaddthird = get_post_meta($_REQUEST['post'], 'contentaddthird', true);
        $contentaddfourth = get_post_meta($_REQUEST['post'], 'contentaddfourth', true);

        $check1 = get_post_meta($_REQUEST['post'], 'check1', true);
        $check2 = get_post_meta($_REQUEST['post'], 'check2', true);
        $check3 = get_post_meta($_REQUEST['post'], 'check3', true);
        $check4 = get_post_meta($_REQUEST['post'], 'check4', true);
    }
    ?>
    <div class="event-date">
        <h3>Event Date</h3>
        <?php
        $id = 'eventdates';
        $settings = array(
            'media_buttons' => false,
            'editor_height' => '100'
        );
        wp_editor($eventdates, $id, $settings);
        ?>

        <h3>Heading Background Color</h3>

        <p><input type="text" name="textbg_color" id="textbg_color" value="<?php echo($textbg_color); ?>"/></p>
        </tr>
    </div>

    <div class="uploader">
        <h3 class="content-title">First Row Content</h3>
        <?php if ($check1 == "") { ?>
            <p>Show this content <input name="check1" type="checkbox" value="yes"></p>
        <?php } else if ($check1 == "yes") { ?>
            <p>Show this content <input name="check1" type="checkbox" value="yes" checked></p>
        <?php }

        $id = 'contentaddfirst';
        $settings = array(
            'media_buttons' => false,
            'tinymce' => true,
            'editor_height' => '200',
        );
        wp_editor($contentaddfirst, $id, $settings);

        if ($upload_image) { ?>
            <img src="<?php echo $upload_image; ?>" width="200" id="image-preview" class="image-preview"/>
        <?php } ?>
        <input id="upload_image" name="upload_image" type="text" value="<?php echo $upload_image; ?>"
               class="regular-text"/>
        <input id="upload_image_button" class="button" name="upload_image_button" type="text" value="Add Image"/>
    </div>

    <div class="uploader">
        <h3 class="content-title">Second Row Content</h3>
        <?php if ($check2 == "") { ?>
            <p>Show this content <input name="check2" type="checkbox" value="yes"></p>
        <?php } else if ($check2 == "yes") { ?>
            <p>Show this content <input name="check2" type="checkbox" value="yes" checked></p>
        <?php }
        $id = 'contentaddtwo';
        $settings = array(
            'media_buttons' => false,
            'tinymce' => true,
            'editor_height' => '200',
        );
        wp_editor($contentaddtwo, $id, $settings);
        ?>
        <?php if ($upload_image2) { ?>
            <img src="<?php echo $upload_image2; ?>" width="200" id="image-preview2" class="image-preview"/>
        <?php } ?>
        <input id="upload_image2" name="upload_image2" type="text" value="<?php echo $upload_image2; ?>"
               class="regular-text"/>
        <input id="upload_image2_button" class="button" name="upload_image2_button" type="text" value="Add Image"/>
    </div>

    <div class="uploader">
        <h3 class="content-title">Third Row Content</h3>
        <?php if ($check3 == "") { ?>
            <p>Show this content <input name="check3" type="checkbox" value="yes"></p>
        <?php } else if ($check3 == "yes") { ?>
            <p>Show this content <input name="check3" type="checkbox" value="yes" checked></p>
        <?php }
        $id = 'contentaddthird';
        $settings = array(
            'media_buttons' => false,
            'tinymce' => true,
            'editor_height' => '200',
        );
        wp_editor($contentaddthird, $id, $settings);
        if ($upload_image3) { ?>
            <img src="<?php echo $upload_image3; ?>" width="200" id="image-preview3" class="image-preview"/>
        <?php } ?>
        <input id="upload_image3" name="upload_image3" type="text" value="<?php echo $upload_image3; ?>"
               class="regular-text"/>
        <input id="upload_image3_button" class="button" name="upload_image3_button" type="text" value="Add Image"/>
    </div>

    <div class="uploader">
        <h3 class="content-title">Fourth Row Content</h3>
        <?php if ($check4 == "") { ?>
            <p>Show this content <input name="check4" type="checkbox" value="yes"></p>
        <?php } else if ($check4 == "yes") { ?>
            <p>Show this content <input name="check4" type="checkbox" value="yes" checked></p>
        <?php }
        $id = 'contentaddfourth';
        $settings = array(
            'media_buttons' => false,
            'tinymce' => true,
            'editor_height' => '200',
        );
        wp_editor($contentaddfourth, $id, $settings);
        if ($upload_image4) { ?>
            <img src="<?php echo $upload_image4; ?>" width="200" id="image-preview4" class="image-preview"/>
        <?php } ?>
        <input id="upload_image4" name="upload_image4" type="text" value="<?php echo $upload_image4; ?>"
               class="regular-text"/>
        <input id="upload_image4_button" class="button" name="upload_image4_button" type="text" value="Add Image"/>
    </div>
<?php
}

function save_post_second_column()
{
    global $post;
    $textbg_color = $_POST['textbg_color'];

    $upload_image = $_POST['upload_image'];
    $upload_image2 = $_POST['upload_image2'];
    $upload_image3 = $_POST['upload_image3'];
    $upload_image4 = $_POST['upload_image4'];

    $check1 = $_POST['check1'];
    $check2 = $_POST['check2'];
    $check3 = $_POST['check3'];
    $check4 = $_POST['check4'];

    $eventdates = $_POST['eventdates'];
    $eventdates = apply_filters('the_content', $eventdates);
    $eventdates = str_replace(']]>', ']]>', $eventdates);

    $contentaddfirst = $_POST['contentaddfirst'];
    $contentaddfirst = apply_filters('the_content', $contentaddfirst);
    $contentaddfirst = str_replace(']]>', ']]>', $contentaddfirst);

    $contentaddtwo = $_POST['contentaddtwo'];
    $contentaddtwo = apply_filters('the_content', $contentaddtwo);
    $contentaddtwo = str_replace(']]>', ']]>', $contentaddtwo);

    $contentaddthird = $_POST['contentaddthird'];
    $contentaddthird = apply_filters('the_content', $contentaddthird);
    $contentaddthird = str_replace(']]>', ']]>', $contentaddthird);

    $contentaddfourth = $_POST['contentaddfourth'];
    $contentaddfourth = apply_filters('the_content', $contentaddfourth);
    $contentaddfourth = str_replace(']]>', ']]>', $contentaddfourth);

    update_post_meta($post->ID, 'eventdates', $eventdates);
    update_post_meta($post->ID, 'contentaddfirst', $contentaddfirst);
    update_post_meta($post->ID, 'contentaddtwo', $contentaddtwo);
    update_post_meta($post->ID, 'contentaddthird', $contentaddthird);
    update_post_meta($post->ID, 'contentaddfourth', $contentaddfourth);
    update_post_meta($post->ID, 'upload_image', $upload_image);
    update_post_meta($post->ID, 'upload_image2', $upload_image2);
    update_post_meta($post->ID, 'upload_image3', $upload_image3);
    update_post_meta($post->ID, 'upload_image4', $upload_image4);
    update_post_meta($post->ID, 'textbg_color', $textbg_color);
    update_post_meta($post->ID, 'check1', $check1);
    update_post_meta($post->ID, 'check2', $check2);
    update_post_meta($post->ID, 'check3', $check3);
    update_post_meta($post->ID, 'check4', $check4);
}
