<?php
/**
 * The template for displaying all pages.
 *
 */

get_header(); ?>

<div class="inner_content">
	<h1 class="title-divider"><?php the_title(); ?><span></span></h1>

	<div class="row">
		<div class="span12">
			<?php 
			while ( have_posts() ) : the_post(); 
				the_content(); 
			endwhile; // end of the loop. ?>
		</div>	
	</div>
</div>

<?php get_footer();?>