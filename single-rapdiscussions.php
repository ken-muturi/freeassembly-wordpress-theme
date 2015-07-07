<?php
/**
 * The template for displaying Single pages.
 *
 */

get_header(); ?>

<div class="inner_content">
	<h1 class="title-divider"><?php the_title(); ?><span></span></h1>

	<div class="row">
		<div class="span12">
			<div class="post">
				<div class="row">
					<?php 
					$id = get_the_id();
			        $key ='rapdiscussions_discussions_info';
			        $date = get_post_meta($id, $key.'_release_date', true);
			        $release_date = '';
			        if(! empty($date)) 
			        {
			            $day = date('d', strtotime($date));
			            $month = date('M', strtotime($date));
			            $year = date('Y', strtotime($date));

			            $release_date .= '<div class="span1">';
			            $release_date .= '<div class="date-post2"><span class="day hue">'. $day .'</span><span class="month">'. $month .'</span><span class="year">'. $year .'</span></div>';
			            $release_date .= '</div>';
			        }
			        echo  $release_date;
					?>

					<div class="span11">
						<?php 						
						while ( have_posts() ) : the_post(); 
					        if ( has_post_thumbnail() ) 
					        {?>
					        	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('large'); ?></a>
					        <?php 
					        } 							
							the_content(); 						
						endwhile; // end of the loop. ?>

						<div class='row'>
							<div class='span12'>
								<?php comments_template(); ?>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>