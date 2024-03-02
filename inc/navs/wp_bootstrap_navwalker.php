<?php
// bootstrap 5 wp_nav_menu walker
class WP_Bootstrap_Navwalker extends Walker_Nav_menu
{
	private $current_item;
	private $dropdown_menu_alignment_values = [
		'dropdown-menu-start',
		'dropdown-menu-end',
		'dropdown-menu-sm-start',
		'dropdown-menu-sm-end',
		'dropdown-menu-md-start',
		'dropdown-menu-md-end',
		'dropdown-menu-lg-start',
		'dropdown-menu-lg-end',
		'dropdown-menu-xl-start',
		'dropdown-menu-xl-end',
		'dropdown-menu-xxl-start',
		'dropdown-menu-xxl-end'
	];
	/* this version is a good starting point for a mega nav
						   function start_lvl(&$output, $depth = 0, $args = null)
						   {
							 $dropdown_menu_class[] = '';
							 foreach($this->current_item->classes as $class) {
							   if(in_array($class, $this->dropdown_menu_alignment_values)) {
								 $dropdown_menu_class[] = $class;
							   }
							 }
							 $indent = str_repeat("\t", $depth);
							 $submenu = ($depth > 0) ? ' sub-menu' : '';
							 if($depth === 0){
								 $output .= "\n$indent<ul class=\"megamenu justify-content-end dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
							 } else {
								 
								 $output .= "\n$indent<ul class=\"list-unstyled $submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
							 }
						   } */
	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		$dropdown_menu_class[] = '';
		foreach ($this->current_item->classes as $class) {
			if (in_array($class, $this->dropdown_menu_alignment_values)) {
				$dropdown_menu_class[] = $class;
			}
		}

		//$this->current_item
		$indent = str_repeat("\t", $depth);
		$submenu = ($depth > 0) ? ' sub-menu' : '';
		$output .= "\n$indent<ul role='menu' class=\"list-unstyled dropdown-menu $submenu " . esc_attr(implode(" ", $dropdown_menu_class)) . " depth_$depth\">\n";


		//$sectionTitle = $this->current_item->title;


		if ($depth === 0 && $args->walker->has_children) {
			$output .= $this->duplicateParentItem($this->current_item, $args);
		}

	}
	private function duplicateParentItem($item, $args)
	{
		$indent = str_repeat("\t", 1); // Adjust the indentation as needed
		$classes = 'nav-item  dropdown-item'; // You can modify the classes as needed

		$output = "$indent<li class=\"$classes close-nav-dropdown-li d-lg-none\">\n";
		$output .= '<a href="#" class="dropdown-toggle justify-content-between close-nav-dropdown"><i class="fa fa-angle-left fa-1x" aria-hidden="true"></i>Back<span></span></a>';
		$output .= "$indent</li>\n";

		$classes .= ' dropdown-header'; // You can modify the classes as needed
		if (!empty($item->url) && $item->url !== '#') {
			$output .= "$indent<li class=\"$classes\">\n";
			$output .= "$indent\t<a href=\"$item->url\" class=\"nav-header\">$item->title</a>\n";
			$output .= "$indent</li>\n";
		}
		return $output;
	}
	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$nav_icon = get_field('icon');
		$this->current_item = $item;

		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$li_attributes = '';
		$class_names = $value = '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;

		$enable_search_form = get_field('enable_search_form', $item);
		$nav_icon = get_field('icon', $item);
		$custom_nav_item_class = get_field('custom_nav_item_class', $item);

		$classes[] = ($args->walker->has_children && $depth === 0) ? 'dropdown' : '';
		$classes[] = 'nav-item';
		$classes[] = 'nav-item-' . $item->ID;
		if ($custom_nav_item_class) {
			$classes[] = $custom_nav_item_class;
		}
		if ($depth === 2 && $args->walker->has_children) {
			$classes[] = 'dropdown-menu dropdown-menu-end';
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
		$sectionTitle = '';
		$closeSection = '';
		if ($args->walker->has_children && $depth === 0) {
			$sectionTitle = apply_filters('the_title', $item->title, $item->ID);
			$closeSection = '<a ' . $attributes . ' class="menu-item close-dropdown" aria-label="Close">' . $sectionTitle . '</a>';
		}

		if ($args->walker->has_children && $depth === 0) {
		}
		$output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';


		$active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? '' : '';
		if ($depth === 1) {
			$nav_link_class = ($depth > 0) ? 'dropdown-item text-uppercase font-weight-bolder' : 'nav-link ';
		} else if ($depth === 2) {
			$nav_link_class = ($depth > 0) ? 'dropdown-item final_level' : 'nav-link ';
		} else {

			$nav_link_class = ($depth > 0) ? 'dropdown-item ' : 'nav-link ';
		}

		$attributes .= ($args->walker->has_children && $depth === 0) ? ' class="' . $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="' . $nav_link_class . ' ' . $custom_nav_item_class . ' ' . $active_class . '"';

		$item_output = $args->before;
		if ($enable_search_form == 1):
			$item_output = theme_main_nav_search();
		else:
			/*
			 * Glyphicons/Font-Awesome
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if (!empty($item->attr_title)) {
				$pos = strpos(esc_attr($item->attr_title), 'glyphicon');
				if (false !== $pos) {
					$item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr($item->attr_title) . '" aria-hidden="true"></span>&nbsp;';
				} else {
					$item_output .= '<a' . $attributes . '><i class="fa ' . esc_attr($item->attr_title) . '" aria-hidden="true"></i>&nbsp;';
				}
			} else {
				$item_output .= '<a' . $attributes . '>';
			}
			$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
			if ($args->walker->has_children && $depth === 0) {
				$item_output .= '<i class="fa fa-angle-right d-lg-none" aria-hidden="true"></i>';
				$item_output .= '<i class="fa fa-angle-down d-none d-lg-inherit" aria-hidden="true"></i>';
				$item_output_after = $closeSection;

			}
			if ($nav_icon) {
				$item_output .= $nav_icon;
			}
			$item_output .= '</a>';
		endif;
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}
// register a new menu

register_nav_menu('bs-menu', 'bootstrap menu');