<?php get_header(); ?>

<?php nectar_page_header($post->ID); ?>

<div class="container-wrap">
	
	<div class="container main-content">
		
		<div class="row">

				<?php if( is_front_page()) { ?>
					<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/packages/flipcountdown/jquery.flipcountdown.js"></script>
					<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/packages/flipcountdown/jquery.flipcountdown.css">
					<script>
					
					// initialize timer
					jQuery(function() {
					    jQuery('.transparent-bg > span:nth-child(1)').flipcountdown({
					        size : 'md',
					        beforeDateTime : '1/09/2015 00:00:01'
					    });
						// add labels to the timer
						// jQuery(document).ready(function() {
							// jQuery('.xdsoft_digit:nth-child(1)').prepend('<h1>Days</h1>');
						// });
					});
					
					</script>
				<?php } ?>
			
			<?php 
			 //buddypress
			 global $bp; 
			 if($bp && !bp_is_blog_page()) echo '<h1>' . get_the_title() . '</h1>'; ?>
			
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				
				<?php the_content(); ?>
	
			<?php endwhile; endif; ?>
				
	
		</div><!--/row-->
		
	</div><!--/container-->
	
</div>
<?php get_footer(); ?>