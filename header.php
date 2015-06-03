<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php global $page, $paged;
        wp_title( '|', true, 'right' );
        bloginfo( 'name' ); ?></title>

    <!-- Bootstrap -->
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet">
    <link href="http://getbootstrap.com/examples/carousel/carousel.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php  wp_head();?>
</head>
<body>
<header>
    <div class="container">
            <div class="header clearfix">
                <a class="navbar-brand" href="<?php bloginfo("url"); ?>"><img src="<?php echo bloginfo('template_directory'); ?>/images/logo.png" class="logo"></a>
                <a class="navbar-brand" href="<?php bloginfo("url"); ?>"><h3 class="site-title"><?php echo bloginfo( 'name' );?></h3></a>
            </div>
    </div>
</header>
<?php
if(is_front_page()){
global $wpdb;

$postsphotos = $wpdb->get_results("SELECT * FROM " . BMMI_PHOTO_TBL . " WHERE postID = $post->ID LIMIT 1");
$pcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM " . BMMI_PHOTO_TBL . " WHERE postID = %d", $post->ID));

$postsphotos2 = $wpdb->get_results("SELECT * FROM " . BMMI_PHOTO_TBL . " WHERE postID = $post->ID limit 1,18446744073709551615");
$pcount2 = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM " . BMMI_PHOTO_TBL . " WHERE postID = %d", $post->ID));

if ($pcount > 0) {
    foreach ($postsphotos as $postsphoto) {
    $image = matthewruddy_image_resize( $postsphoto->imageurl, '891', '523');
    $photoimage .= '<img src="' . $image['url'] . '" />';
    }
}
?>
<div class="jumbotron carousel-container">
    <div class="container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <?php echo $photoimage; ?>
                </div>
                <?php
                if ($pcount2 > 0) {
                    foreach ($postsphotos2 as $postsphoto2) {
                        $image2 = matthewruddy_image_resize( $postsphoto2->imageurl, '891', '523');
                        ?>
                        <div class="item ">
                            <img src="<?php echo $image2['url']; ?>" >
                        </div>
                    <?php }
                } ?>
            </div>
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"><</span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true">></span>
                <span class="sr-only">Next</span>
            </a>
        </div><!-- /.carousel -->
    </div>
</div>
<div class="jumbotron home-topcontent">
    <div class="container">
        <?php
        while ( have_posts() ) : the_post(); ?>
        <div  class="entry">
            <?php the_content(); ?>
        </div>
        <?php endwhile;  ?>
    </div>
    <div class="clouds-bg"></div>
</div>

<?php } ?>
<div class="container">