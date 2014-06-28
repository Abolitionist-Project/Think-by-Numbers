<?php
require_once('helpers.php');
require_once('shortcodes.php');
require_once('breadcrumbs.php');
require_once('cuztom/cuztom.php');
require_once('wp-customizer/wp-customizer.php');
require_once('admin-panel/euged-admin.php');

class Arrow_Walker_Nav_Menu extends Walker_Nav_Menu {
	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
		$id_field = $this->db_fields['id'];
		if (!empty($children_elements[$element->$id_field])) {
			$element->classes[] = 'has-sub-menu'; //enter any classname you like here!
		}
		Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}
