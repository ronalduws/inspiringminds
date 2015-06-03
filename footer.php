</div><!-- /.container -->

<footer>
	<div class="home-bottomcontent">

		<div class="container">
			<?php $contentaddbottom = get_post_meta($post->ID,'contentaddbottom',true); ?>
			<div  class="entry">
				<?php echo $contentaddbottom; ?>
			</div>
		</div>
	</div>
	<div class="jumbotron footer-content">
		<div class="container">
			<?php
			$footercontentleft = get_post_meta($post->ID,'footercontentleft',true);
			$footercontentright = get_post_meta($post->ID,'footercontentright',true);
			$footercontentbottom = get_post_meta($post->ID,'footercontentbottom',true);
			?>
			<div class="row">
				<div class="col-md-6">
					<div  class="footer-left">
						<?php echo $footercontentleft; ?>
					</div></div>
				<div class="col-md-6">
					<div  class="footer-right">
						<?php echo $footercontentright; ?>
					</div>
				</div>
			</div>

			<div  class="footer-bottom">
				<?php echo $footercontentbottom; ?>
			</div>
		</div>
	</div>
	<div id="footer-bar"></div>
</footer>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>
<!-- Script to Activate the Carousel -->
<script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
</script>
</body>
</html>