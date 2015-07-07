<?php
/**
 * The main template file.
 */

get_header(); ?>
<div class="inner_content">
	<h1 class="title">Our Blog - Creativity For All<span></span></h1>
<div class="row">
<div class="span9">
	<?php 
	if ( have_posts() ) 
	{
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 

		while ( have_posts() ) 
		{
		 the_post(); ?>
		<div class="post">
			<div class="row">
				<div class="span9"> 
					<div class="date-post">
						<span class="day hue"><?php the_time('j'); ?></span>
						<span class="month"><?php the_time('M'); ?></span>
					</div>
				<?php 
					if(has_post_thumbnail()) 
					{ 
						the_post_thumbnail('full', array('data-rel' => "prettyPhoto"));
					} 
				?> 
					<h2 class="title-divider span9 post_link pad15"><a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?> </strong></a><span></span></h2>
		
					<div class="clear"></div>

					<div class="post-meta">
						<ul>
							<li>Posted by <?php the_author_link(); ?> <span class="muted">/</span></li>
							<li><i class="icon-calendar normal muted"></i> <?php the_date(); ?> /</li>
							<li><i class="icon-bullhorn normal muted"></i> <?php the_category(' '); ?> /</li>
							<li><i class="icon-comment-alt muted"></i><a href="<?php comments_link(); ?>"><?php comments_number('0','1','%'); ?> comments</a></li>
						</ul>
					</div>
					
					<!--end meta--> 
					<p>			
					<?php
					if( is_archive() || is_search() ) //display excerpts on for the archives and search page
					{ 
						the_excerpt(); 
					} 
					else 
					{
		        		the_content('Read More');
					} ?>
					</p>
						
					<!-- <p><a href="blog_post.html" class="more-link">Continue reading &rarr;</a></p> -->
				</div>
			</div>
    	</div>
	<?php 	
		} 

	    wp_reset_query(); 
	} else { // end have_posts() check ?>   

	There are not blog posts yet.
	<?php } ?> 	 
</div>
<!--end post-->
<!--sidebar-->
<div class="span3">
<?php get_sidebar(); ?>	
</div>	
		
</div>
</div>
<?php get_footer(); ?>