<?php get_header(); ?>

<div  class="entry">
    <?php
    $pheading = get_post_meta($post->ID,'pheading',true);
    $pquote = get_post_meta($post->ID,'pquote',true);
    while ( have_posts() ) : the_post();
        $title_post = $pheading ? $pheading : get_the_title();
        echo "<h1 class=\"pagetitle\">$title_post</h1>";
        if($pquote)
        {
            $pquote = apply_filters('the_content', $pquote);
            $pquote = str_replace(']]>', ']]>', $pquote);
            echo $pquote;
        }
        the_content();
    endwhile; // End the loop.
    ?>
</div><!-- //entry -->

<?php get_footer(); ?>
