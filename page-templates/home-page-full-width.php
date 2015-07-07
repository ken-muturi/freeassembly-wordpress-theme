<?php
/**
 * Template Name: Welcome Full width
 */

get_header(); ?>
<!--info boxes-->

<div class="welcome">
	<?php 
	if ( dynamic_sidebar('theme_home_page_quotes') ) : 
	else : 
	?>
	<?php endif; ?>
</div>

<!-- nivo slider starts -->
<div class="slider-wrapper theme-default">
<div class="row">
	<div class="span12">
		<?php  echo do_shortcode('[widgetkit id=85]') ?>
	</div>
</div>
</div>
<!-- slider ends -->
<div class="clear"></div>

<div class="inner_content">
	<div class="row">
	<?php 
		while ( have_posts() ) : the_post(); 
			the_content(); 
		endwhile; // end of the loop. 
	?>
	</div>
</div>	
<?php get_footer(); ?>