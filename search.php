<?php
/**
 * The template for displaying all pages.
 *
 */

get_header(); ?>

<div class="inner_content">
	<h1 class="title-divider"><strong>Search </strong>Results<span></span> </h1>
	<div class="row">
		<div class="span12">
			<?php
			if ( have_posts() ) : 
				while ( have_posts() ) : the_post(); ?>
					<h3> <a href='<?php the_permalink();?>'><?php the_title();?></a> </h3>
					<p> <?php the_excerpt();?> </p>
				<?php
				endwhile; // end of the loop. 
			else : ?>

			<div class='no_page'> 
			<?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?>
			<?php get_search_form();?> 
			</div>	

			<?php endif; ?>
		</div>	
	</div>
</div>

<?php get_footer();?>
