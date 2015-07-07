<?php
class Sf_Walker extends Walker_Nav_Menu 
{
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) 
	{
		$id_field = $this->db_fields['id'];
		if ( !empty( $children_elements[$element->$id_field] ) && ( depth == 0 ) ) 
		{
			$element->classes[] = 'has-children'; // Use any classname you like
		}
		Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}