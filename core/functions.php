<?php

if (!defined('ABSPATH')) { exit; }

function gdclw_load_template($templates) {
    $template = locate_template($templates);

    if (empty($template)) {
        $template = GDCLW_PATH.'templates/'.$templates;
    }

    return $template;
}

function gdclw_widget_render_header($instance, $widget_base, $base_class = 'gdclw-navigator') {
    $class = array('gd-clever-widget', $base_class);
    $class[] = str_replace('_', '-', $widget_base);

    if ($instance['_class'] != '') {
        $class[] = $instance['_class'];
    }

    if (isset($instance['_style']) && !empty($instance['_style']) && $instance['_style'] != '__none__') {
        $class[] = $instance['_style'];
    }

    $render = '<div class="'.join(' ', $class).'">'.D4P_EOL;

    if ($instance['before'] != '') {
        $render.= '<div class="clw-before">'.$instance['before'].'</div>';
    }

    return $render;
}

function gdclw_widget_render_footer($instance) {
    $render = '';

    if ($instance['after'] != '') {
        $render.= '<div class="clw-after">'.$instance['after'].'</div>';
    }

    $render.= '</div>';

    return $render;
}

function gdcls_list_post_types($filter = array('public' => true)) {
    $list_types = array();
    $post_types = get_post_types($filter, 'objects');

    foreach ($post_types as $cpt => $obj) {
        $list_types[$cpt] = $obj->labels->name;
    }

    return $list_types;
}

function gdclw_length_sort($a, $b){
    return strlen($b) - strlen($a);
}
