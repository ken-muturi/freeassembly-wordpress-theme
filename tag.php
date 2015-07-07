<?php
/**
 * The template for displaying Tag pages.
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<div class="inner_content">
	<?php
	 if ( have_posts() ) : ?>
		<h1 class="title-divider">Tag - <?php single_tag_title(); ?><span></span></h1>

		<?php if ( tag_description() ) : // Show an optional tag description ?>
			<div class="archive-meta"><?php echo tag_description(); ?></div>
		<?php endif; ?>

		<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post(); ?>

			<div class="row">
				<?php
				global $post;
					
				$type = get_post_type( $post->ID );
				$custom_post_types = array('rapporteurpressnews', 'rapporteurreports', 'rapdiscussions');
				
				$date = get_the_date('F j, Y');
				if(in_array($type, $custom_post_types))
		        {					
					$rapporteurpressnews = get_post_meta($post->ID, 'rapporteurpressnews_rapporteur_press_news_release_date', true);
					$rapporteurreports = get_post_meta($post->ID, 'rapporteurreports_rapporteur_reports_release_date', true);
					$rapdiscussions = get_post_meta($post->ID, 'rapdiscussions_discussions_info_release_date', true);

					$date = $post->post_date;
		            if(! empty($rapporteurreports)) 
		            {
		            	$date = $rapporteurreports;
		            }
		            
		            if(! empty($rapporteurpressnews)) 
		            {
		            	$date = $rapporteurpressnews;
		            }	

		            if(! empty($rapdiscussions)) 
		            {
		            	$date = $rapdiscussions;
		            }
		        }

				$day = date('d', strtotime($date));
				$month = date('M', strtotime($date));
				$year = date('Y', strtotime($date));
				?>
				<div class="span1">
					<div class="date-post2"><span class="day hue"><?php echo $day; ?></span><span class="month"><?php echo $month ?></span><span class="year"><?php echo $year; ?></span></div>
				</div>
				<div class="span11">
			        <?php
			        if ( has_post_thumbnail() ) 
			        {?>
			        	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('large'); ?></a>
			        <?php 
			        } ?>

					<?php if ( is_single() ) : ?>
					<h2 class='title-divider span11 post_link pad15'><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a><span></span></h2> 
					<?php else : ?>
					<h2 class='title-divider span11 post_link pad15'><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a><span></span></h2> 
					<?php endif; ?>
						

					<?php if ( is_search() ) : // Only display Excerpts for Search ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->

					<?php else : ?>
						<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>') ); ?>
						
						<?php wp_link_pages( array( 'before' => 'p' . __( 'Pages:'), 'after' => '</p>' ) ); ?>

					<?php endif; ?>
				</div>
			</div>

		<?php 
		endwhile;
		?>

	<?php else : ?>
		<?php get_template_part( 'content', 'none' ); ?>
	<?php endif; ?>

</div>
<?php get_footer(); ?>