<?php
/**
 * Template Name: Contact us
 */


get_header(); ?>

<div class="inner_content">
	<div class="row pad25">
		<div class="span4">
			<h3 class="title-divider span4">Contact<strong> Us</strong><span></span></h3>
			<p>If you have any questions for the UN Special Rapporteur, or if you would like to file a complaint regarding a freedom of assembly or association violation, please feel free to contact us via e-mail, fax or post.</p>

			<p>Alternatively, you may use our web contact form on the right. Note that data sent through the form is not encrypted. </p>
			<?php 
			while ( have_posts() ) : the_post(); 
				the_content(); 
			endwhile; // end of the loop. ?>
		</div>	
		<div class="span8">
			<div class='contact_form well'>
				<?php  echo do_shortcode('[contact-form-7 id="57" title="Contact form 1"]') ?> 
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>