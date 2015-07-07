<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
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

		<h3 class="title-divider"><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a> <span></span></h3> 		

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<?php else : ?>
			<?php //the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>') ); ?>
			<?php the_excerpt(); ?>
			<?php wp_link_pages( array( 'before' => 'p' . __( 'Pages:'), 'after' => '</p>' ) ); ?>

		<?php endif; ?>
	</div>
</div>