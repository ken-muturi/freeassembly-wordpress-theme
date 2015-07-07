<?php 
    /**
     * Portfolio Page
     */
    
    get_header(); 
?>
<div class="container">
    <div class="row">
        <div class="inner_content">
            <h1 class="title-divider"><?php the_title(); ?><span></span></h1>
            <!-- portfolio_block --> 
            <?php  echo do_shortcode('[kencrestportfolio]') ?> 
            <!-- //portfolio_block -->   
        </div>
    </div>
</div>
<?php get_footer();?>