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

<?php 
	// while ( have_posts() ) : the_post(); 
	// 	the_content(); 
	// endwhile; // end of the loop. 
?>

<div class="inner_content">
	<div class="row">
		<div class="span4">
			<div class="quote_sections_hue service_sections">
				<div class="intro-icon-disc cont-large intro-icon"><i class="icon-columns intro-icon-large"></i></div>
				<h4 class="title-divider pad10"><strong>Latest Discussions </strong><span></span></h4>
				<!-- <div class='rapporteurabout'> -->
					<?php  //echo do_shortcode('[rapporteurshortcode type=rapporteurcountries tax=report_type metakey=rapporteur_countries numberposts=10]') ?>
					<?php  
						// while ( have_posts() ) : the_post(); 
						// 	the_content(); 
						// endwhile; // end of the loop. 
					?>
				<!-- </div> -->
				<ul class='media-list rapporteurnewitems'>
					<?php  echo do_shortcode('[rapporteurshortcode type=rapdiscussions  tax=discussions_type metakey=discussions_info numberposts=10]') ?>
				</ul> 	
				<div class="pad25"></div>
			</div>
			<div class="pad45"></div>
		</div>

		<div class="span4">
			<div class="quote_sections_hue service_sections">
				<div class="intro-icon-disc cont-large intro-icon"> <i class="icon-book intro-icon-large"></i></div>
				<h4 class="title-divider pad10"><strong>Latest Reports</strong> <span></span></h4>
				<ul class='media-list rapporteurnewitems'>
					<?php  echo do_shortcode('[rapporteurshortcode type=rapporteurreports tax=type metakey=rapporteur_reports numberposts=10]') ?>
				</ul> 
				<div class="pad25"></div>
			</div>
			<div class="pad45"></div>
		</div>

		<div class="span4">
			<div class="quote_sections_hue service_sections">
				<div class="intro-icon-disc cont-large intro-icon"><i class="icon-resize-small intro-icon-large"></i></div>
				<h4 class="title-divider pad10"><strong>Latest News</strong><span></span></h4>
				<ul class='media-list rapporteurnewitems'>
					<?php  echo do_shortcode('[rapporteurshortcode type=rapporteurpressnews tax=press_category metakey=rapporteur_press_news numberposts=10]') ?>
				</ul>	 
				<div class="pad25"></div>
			</div>
			<div class="pad45"></div>
		</div>
	</div>
</div>	
<?php get_footer(); ?>