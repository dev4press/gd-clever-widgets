<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_Walker_DropDown_NavMenu extends Walker_Nav_Menu {
    function is_dropdown() {
        return true;
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $classes[] = 'menu-item-'.$item->ID;

        if (in_array('menu-item-has-children', $classes)) {
            $class_names = ' class="'.esc_attr(join(' ', array_unique(array_filter($classes)))).'"';

            $selected = $args->selected_item == $item->ID ? ' selected="selected"' : '';

            $output.= '<option'.$class_names.' value="'.$item->ID.'"'.$selected.'>';

            $indent_string = str_repeat($args->indent_string, ($depth) ? $depth : 0);
            $indent_string.= !empty( $indent_string ) ? $args->indent_after : '';

            $item_output = $args->before.$indent_string;
            $item_output.= $args->link_before.apply_filters('the_title', $item->title, $item->ID).$args->link_after;
            $item_output.= $args->after;

            $output.= $item_output;
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output.= "</option>\n";
    }
}

class gdclw_Walker_DropDown_Page extends Walker_PageDropdown {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $pad = str_repeat('&nbsp;', $depth * 3);

        $output.= "\t<option class=\"level-$depth\" value=\"$item->ID\"";

        if (in_array($item->ID, $args['selected'])) {
            $output.= ' selected="selected"';
        }

        $output.= '>';
        $output.= $pad.esc_html($item->post_title);
        $output.= "</option>\n";
    }
}

class gdclw_Walker_DropDown_Term extends Walker_CategoryDropdown {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $pad = str_repeat('&nbsp;', $depth * 3);

        $output.= "\t<option class=\"level-$depth\" value=\"".$item->term_id."\"";

        if (in_array($item->term_id, $args['selected'])) {
            $output.= ' selected="selected"';
        }

        $output.= '>';
        $output.= $pad.$item->name;
        $output.= "</option>\n";
    }
}
