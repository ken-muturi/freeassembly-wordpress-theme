<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div class="row">
		<div class="span12">
		<div class="no_page">
			<span class="very_big"> 4<span class="hue">0</span>4</span> 
			</div>
		</div>
		<div class="span12">
			<div class="welcome">
				<h3 class="no_page">The page you are looking for is not here <br>
				 - Please <a href="<?php echo network_site_url( '/' ); ?> ">continue browsing!</a> -</h3>

				
				<div class='no_page'><p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>