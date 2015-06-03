<?php get_header();

    global $wpdb;
    $textbg_color = get_post_meta($post->ID, 'textbg_color', true);
    $eventdates = get_post_meta($post->ID, 'eventdates', true);

    $pheadingsecond = get_post_meta($post->ID,'pheadingsecond',true);
    $contentaddfirst = get_post_meta($post->ID,'contentaddfirst',true);
    $contentaddtwo = get_post_meta($post->ID,'contentaddtwo',true);
    $contentaddthird = get_post_meta($post->ID,'contentaddthird',true);
    $contentaddfourth = get_post_meta($post->ID,'contentaddfourth',true);

    $upload_image = get_post_meta($post->ID,'upload_image',true);
    $upload_image2 = get_post_meta($post->ID,'upload_image2',true);
    $upload_image3 = get_post_meta($post->ID,'upload_image3',true);
    $upload_image4 = get_post_meta($post->ID,'upload_image4',true);

    $check1 = get_post_meta($post->ID,'check1',true);
    $check2 = get_post_meta($post->ID,'check2',true);
    $check3 = get_post_meta($post->ID,'check3',true);
    $check4 = get_post_meta($post->ID,'check4',true);

    $image = matthewruddy_image_resize( $upload_image, '318', '184');
    $image2 = matthewruddy_image_resize( $upload_image2, '318', '184');
    $image3 = matthewruddy_image_resize(  $upload_image3, '318', '184');
    $image4 = matthewruddy_image_resize(  $upload_image4, '318', '184');
     $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
    $url = $thumb['0'];
?>
<div class="inner-page">
  <?php   while ( have_posts() ) : the_post(); ?>
        <div class="event-top" style="background:<?php echo $textbg_color;?>">
            <h1  class="page-title" ><?php echo the_title(); ?></h1>
            <div class="event-date"><?php echo $eventdates ?></div>
        </div>
        <div  class="entry" style="color:<?php echo $textbg_color;?>">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
    <div class="event-rows" style="background:url(<?php echo $url; ?>)">
        <?php if($check1) {?>
        <div class="row-item">
            <div class="row">
                <div class="col-md-4"><img src="<?php echo $image['url']; ?>"></div>
                <div class="col-md-8">
                    <div class="right-content"><?php echo $contentaddfirst; ?></div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if($check2) {?>
        <div class="row-item">
            <div class="row">
                <div class="col-md-4"><img src="<?php echo $image2['url']; ?>"> </div>
                <div class="col-md-8">
                    <div class="right-content"><?php echo $contentaddtwo; ?></div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if($check3) {?>
        <div class="row-item">
            <div class="row">
                <div class="col-md-4"><img src="<?php echo $image3['url']; ?>"></div>
                <div class="col-md-8">
                    <div class="right-content"><?php echo $contentaddthird; ?></div>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if($check4) {?>
        <div class="row-item">
            <div class="row">
                <div class="col-md-4"><img src="<?php echo $image4['url']; ?>"></div>
                <div class="col-md-8">
                    <div class="right-content"><?php echo $contentaddfourth; ?></div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php  get_footer(); ?>



