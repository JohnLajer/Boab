<?php

    /* Collection of Walker classes */

    /*
     * wp_nav_menu();
     *
     * <div class="menu-container>
     *      <ul>                    // start_lvl()
     *          <li><a><span>       // start_el()
     *          </span></a></li>    // end_el()
     *      </ul>                   // end_lvl()
     * </div>
     *
     */

class Walker_NavPrimary extends Walker_Nav_Menu
{

    function start_lvl(&$output, $depth = 0, $args = array()) // ul
    {
        $indent     = str_repeat('\t', $depth);
        $submenu    = ($depth > 0) ? ' sub-menu' : ''; // Detect if this is a sub-menu
        $output     .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth \">\n";

    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) // li a span
    {
        $indent     = $depth > 0 ? str_repeat("\t", $depth) : '';

        $li_attributes  = '';
        $class_names    = $value = '';

        $classes        = !empty($item->classes) ? (array)$item->classes : array();
        $classes[]      = $args->walker->has_children ? 'dropdown' : '';
        $classes[]      = ($item->current || $item->current_item_anchestor) ? 'active' : '';
        $classes[]      = 'menu-item-'. $item->ID;

        // Add sub-submenus
        if( $depth > 0 && $args->walker->has_children )
        {
            $classes[]  = 'dropdown-submenu';
        }

        $class_names    = join( ' ', apply_filters('nav-menu-css-class', array_filter( $classes ), $item, $args ) );
        $class_names    = ' class="'.esc_attr($class_names).'"';

        $id             = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id             = strlen($id) > 0 ? 'id="'.esc_attr($id).'"' : '';

        $output .= "\n$indent<li ".$id . $value . $class_names . $li_attributes.">";

        $attributes = !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
        $attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
        $attributes .= !empty($item->url) ? ' href="'.esc_attr($item->url).'"' : '';

        $attributes .= $args->walker->has_children ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

        $item_output = $args->before;
        $item_output .= '<a '.$attributes.'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= ($depth == 0 && $args->walker->has_children) ? '<b class="caret"></b></a>' : '</a>';
        $item_output .= $args->before;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // End functions:
    /*
    function end_el() // closing li a span
    {

    }

    function end_lvl() // closing ul
    {

    }
    */

}

?>