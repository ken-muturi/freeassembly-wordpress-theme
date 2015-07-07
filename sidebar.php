<?php
/**
 * The sidebar containing the main widget area.
 */

echo "<h3>Tags:-<h3>";
wp_tag_cloud( 'format=list&smallest=9&largest=9' );

$terms = get_terms('press_category');
if($terms)
{
	echo "<h3>Press Category:-<h3>";
    $post_terms = array();
    foreach ($terms as $term) 
    {
        $term_link = get_term_link( $term );            
        $post_terms []= "&nbsp; <i class='icon-star-empty grey'></i> <a data-placement='top' href='{$term_link}' rel='tooltip' data-original-title='{$term->name}'> {$term->name}</a> ";
    }
   echo '<ul><li>'. join('</li><li>', $post_terms)."</ul>"; 
}

// $terms = get_terms('report_type');
// if($terms)
// {
// 	echo "<h3>Report Types:-<h3>";
//     $post_terms = array();
//     foreach ($terms as $term) 
//     {
//         $term_link = get_term_link( $term );            
//         $post_terms []= "&nbsp; <i class='icon-star-empty grey'></i> <a data-placement='top' href='{$term_link}' rel='tooltip' data-original-title='{$term->name}'> {$term->name}</a> ";
//     }
//    echo '<ul><li>'. join('</li><li>', $post_terms)."</ul>";  
// }

$terms = get_terms('type');
if($terms)
{
	echo "<h3>Types:-<h3>";
    $post_terms = array();
    foreach ($terms as $term) 
    {
        $term_link = get_term_link( $term );            
        $post_terms []= "&nbsp; <i class='icon-star-empty grey'></i> <a data-placement='top' href='{$term_link}' rel='tooltip' data-original-title='{$term->name}'> {$term->name}</a> ";
    }
   echo '<ul><li>'. join('</li><li>', $post_terms)."</ul>"; 
}    