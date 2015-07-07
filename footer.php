<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 */
?>

</div>
<!--//container wrapper-->

<!--footer-->
<div id="footer">
	<div class="container">
		<div class="row">
			<!--column 1-->
			<div class="span3">
				<?php 
				if ( ken('theme_footer_widget') ) : 
				else : 
				?>
				<?php endif; ?>				
			</div>	

			<div class="span3">
				<?php 
				if ( ken('theme_contact_info_widget') ) : 
				else : 
				?>
				<?php endif; ?>
			</div>			

			<div class="span3">
				<h6>Assembly &amp; Association newsletters</h6>
				<?php 
					ken(); 
				?>
			</div>
			<!--column 4-->
			<div class="span3">
			<!--flickr-->
			<h6>Social Media</h6>
				<div class="follow_us">
					<a href="#" class="zocial twitter"> </a>
					<a href="#" class="zocial facebook"> </a>
					<a href="#" class="zocial rss"> </a>
				</div>
				<div class="copyright">
					<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> Copyright &copy; <?php echo date('Y', time());?>
					&nbsp; 
				</div>
			</div>

		</div>
	</div>
</div>
<!--//footer-->

<!-- up to top -->
<a href="#"><i class="go-top hidden-phone hidden-tablet  icon-double-angle-up"></i></a>
<a href="#"><i class="go-down hidden-phone hidden-tablet  icon-double-angle-down"></i></a>
<!--//end-->

<?php wp_footer(); ?>
</body>
</html>