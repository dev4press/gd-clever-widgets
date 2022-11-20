<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Navigator_Terms extends d4p_widget_core {
    public $widget_base = 'd4p_clw_navterms';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $defaults = array(
        'title' => 'Terms Navigator',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-navigator-elegant',
        'dummy_data' => 'no',
        'root_content' => 'full',
        'root_item' => -1,
        'root_custom_top' => 'no',
        'root_detect_top' => 'no',
        'exclude' => array(),
        'sort_column' => 'name',
        'sort_order' => 'ASC',
        'taxonomy' => 'category',
        'post_type' => '',
        'level_first' => 12,
        'level_inner' => 12,
        'hide_empty' => 'yes',
        'post_counts' => 'yes',
        'show_description' => 'no',
        'animate_method' => 'slideDown',
        'animate_speed' => 300,
        'mark_current' => 'mark',
        'markup_plus' => '&#9658;',
        'markup_minus' => '&#9660;',
        'markup_up' => '&#9650;',
        'markup_more' => 'Show More',
        'markup_wait' => 'Please Wait...',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("AJAX powered navigation for taxonomy terms.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Terms Navigator", "gd-clever-widgets");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function get_tabkey($tab) {
        $key = $this->get_field_id('tab-'.$tab);

        return str_replace(array('_', ' '), array('-', '-'), $key);
    }

    function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-clever-widgets"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('navterm-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('navigator-display')),
            'markup' => array('name' => __("Markup", "gd-clever-widgets"), 'include' => array('shared-markup')),
            'extra' => array('name' => __("Extra", "gd-clever-widgets"), 'include' => array('shared-wrapper'))
        );

        if (gdclw_settings()->navigator_dummy_data_mode) {
            $_tabs['dev'] = array('name' => __("DEV", "gd-clever-widgets"), 'include' => array('shared-dev'));
        }

        include(GDCLW_PATH.'forms/widgets/shared-loader.php');
    }

    function update($new_instance, $old_instance) {
        $this->init();

        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        //$instance['_cached'] = intval(strip_tags(stripslashes($new_instance['_cached'])));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_style'] = strip_tags(stripslashes($new_instance['_style']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['exclude'] = isset($new_instance['exclude']) ? array_values($new_instance['exclude']) : array();
        $instance['sort_column'] = strip_tags(stripslashes($new_instance['sort_column']));
        $instance['sort_order'] = strip_tags(stripslashes($new_instance['sort_order']));
        $instance['post_type'] = strip_tags(stripslashes($new_instance['post_type']));
        $instance['taxonomy'] = strip_tags(stripslashes($new_instance['taxonomy']));
        $instance['root_content'] = strip_tags(stripslashes($new_instance['root_content']));
        $instance['root_item'] = intval(strip_tags(stripslashes($new_instance['root_item'])));
        $instance['level_first'] = intval(strip_tags(stripslashes($new_instance['level_first'])));
        $instance['level_inner'] = intval(strip_tags(stripslashes($new_instance['level_inner'])));
        $instance['animate_method'] = strip_tags(stripslashes($new_instance['animate_method']));
        $instance['animate_speed'] = intval(strip_tags(stripslashes($new_instance['animate_speed'])));
        $instance['mark_current'] = strip_tags(stripslashes($new_instance['mark_current']));
        $instance['post_counts'] = strip_tags(stripslashes($new_instance['post_counts']));
        $instance['hide_empty'] = strip_tags(stripslashes($new_instance['hide_empty']));
        $instance['show_description'] = strip_tags(stripslashes($new_instance['show_description']));
        $instance['root_custom_top'] = strip_tags(stripslashes($new_instance['root_custom_top']));
        $instance['root_detect_top'] = strip_tags(stripslashes($new_instance['root_detect_top']));
        $instance['dummy_data'] = isset($new_instance['dummy_data']) ? strip_tags(stripslashes($new_instance['dummy_data'])) : 'no';

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['before'])));
            $instance['after'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['after'])));
        }

        $instance['markup_plus'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_plus'])));
        $instance['markup_minus'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_minus'])));
        $instance['markup_up'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_up'])));
        $instance['markup_more'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_more'])));
        $instance['markup_wait'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_wait'])));

        gdclw_clear_cached_terms(array('taxonomy' => $instance['taxonomy'], 'post_types' => $instance['post_type']));

        delete_transient('gdclw_par_'.$instance['taxonomy']);

        return $instance;
    }

    public function init() {
        require_once(GDCLW_PATH.'core/code/navigator.php');
    }

    public function draw_level($instance, $args = array()) {
        global $clw_core_loader;

        $defaults = array('value' => '', 'level' => 0, 'offset' => 0, 'current' => '');
        $args = wp_parse_args($args, $defaults);

        $level = intval($args['level']);
        $load = $level == 0 ? $instance['level_first'] * 2 : $instance['level_inner'] * 2;
        $offset = intval($args['offset']);
        $parent = intval($args['value']);

        $instance = apply_filters('gdclw_widget_arguments_taxonomy_archives', $instance, $this->widget_id, $level, $parent, $offset);

        $atts = array('post_types' => '', 'taxonomy' => $instance['taxonomy'], 'offset' => $offset, 
                      'number' => $load, 'parent' => $parent, 'pad_counts' => true,
                      'order' => $instance['sort_order'], 'orderby' => $instance['sort_column'],
                      'hide_empty' => $instance['hide_empty'] == 'yes', 'exclude' => $instance['exclude']);
        $atts_count = array('post_types' => '', 'hide_empty' => $instance['hide_empty'] == 'yes', 
                            'taxonomy' => $instance['taxonomy'], 'parent' => $parent, 
                            'exclude' => $instance['exclude']);

        if (isset($instance['post_type'])) {
            $atts['post_types'] = $instance['post_type'];
            $atts_count['post_types'] = $instance['post_type'];
        }

        if ($instance['dummy_data'] == 'yes' && gdclw_settings()->navigator_dummy_data_mode) {
            require_once(GDCLW_PATH.'core/code/dummy.php');
            $list = gdclw_dummy_get_taxonomy_archives($atts);
            $count = gdclw_dummy_get_terms_count(array('post_type' => $instance['post_type'], 'parent' => $parent));
        } else {
            $list = gdclw_get_taxonomy_archives($atts);
            $count = gdclw_get_terms_count($atts_count);
        }

        $rargs = array('level' => $level, 'dig_deep' => null, 'total_count' => $count,
                       'offset' => $args['offset'], 'parent' => $parent, 'current' => $args['current'],
                       'widget_name' => 'taxonomy_archives');

        return gdclw_render_list_level($list, $this->id, $instance, $rargs);
    }

    public function results($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $instance = apply_filters('gdclw_widget_arguments_taxonomy_archives_zero', $instance, $this->widget_id);

        $parent = 0; $show_top = false; $up_element = null;
        if (isset($instance['root_content'])) {
            if ($instance['root_content'] == 'custom') {
                if (isset($instance['root_item']) && $instance['root_item'] > 0) {
                    $parent = $instance['root_item'];

                    $show_top = $instance['root_custom_top'] == 'yes';
                }
            } else if ($instance['root_content'] == 'detect') {
                if (is_category() || is_tax() || is_tag()) {
                    $current_term_object = get_queried_object();

                    if ($instance['taxonomy'] == $current_term_object->taxonomy) {
                        $current = get_queried_object_id();

                        if (count(get_term_children($current, $instance['taxonomy'], $instance['exclude'])) > 0) {
                            $parent = $current;
                        } else {
                            $parent = $current_term_object->parent;
                        }

                        $show_top = $instance['root_detect_top'] == 'yes';
                    }
                }
            }
        }

        if ($show_top) {
            $up_element = gdclw_get_taxonomy_term($parent, $instance['taxonomy'], $instance['post_type']);
        }

        $load = $instance['level_first'] * 2;

        $atts = array('post_types' => '', 'taxonomy' => $instance['taxonomy'], 
                      'number' => $load, 'parent' => $parent, 'pad_counts' => true,
                      'order' => $instance['sort_order'], 'orderby' => $instance['sort_column'],
                      'hide_empty' => $instance['hide_empty'] == 'yes', 'exclude' => $instance['exclude']);
        $atts_count = array('post_types' => '', 'hide_empty' => $instance['hide_empty'] == 'yes', 
                            'taxonomy' => $instance['taxonomy'], 'parent' => $parent,
                            'exclude' => $instance['exclude']);

        if (isset($instance['post_type'])) {
            $atts['post_types'] = $instance['post_type'];
            $atts_count['post_types'] = $instance['post_type'];
        }

        if ($instance['dummy_data'] == 'yes' && gdclw_settings()->navigator_dummy_data_mode) {
            require_once(GDCLW_PATH.'core/code/dummy.php');
            $list = gdclw_dummy_get_taxonomy_archives($atts);
            $count = gdclw_dummy_get_terms_count(array('post_type' => $instance['post_type'], 'parent' => $parent));
        } else {
            $list = gdclw_get_taxonomy_archives($atts);
            $count = gdclw_get_terms_count($atts_count);
        }

        $rargs = array('dig_deep' => null, 'total_count' => $count, 'parent' => $parent, 
                       'init' => true, 'current' => gdclw_plugin()->navigator['page'],
                       'widget_name' => 'taxonomy_archives', 'up' => $up_element);

        return gdclw_render_list_level($list, $this->id, $instance, $rargs);
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $render = gdclw_widget_render_header($instance, $this->widget_base);

        if (empty($results)) {
            $render.= '<div class="clw-no-results">';
            $render.= __("There are no results for current widget settings.", "gd-clever-widgets");
            $render.= '</div>';
        } else {
            $render.= '<ul class="clw-top-level">'.$results.'</ul>';
        }

        $render.= gdclw_widget_render_footer($instance);

        echo $render;
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
	    gdclw_plugin()->load_js();
    }
}

function gdclw_multiselect_terms($args = '') {
    require_once(GDCLW_PATH.'core/code/walkers.php');

    $defaults = array(
        'child_of' => 0, 'echo' => true, 'name' => 'cat', 'id' => '',
        'selected' => array(), 'hierarchical' => true,
        'taxonomy' => 'category', 'hide_empty' => false, 
        'depth' => 0, 'show_count' => 0, 'multiple' => 0, 
        'css_class' => '', 'css_style' => ''
    );

    $args['walker'] = new gdclw_Walker_DropDown_Term();
    $args['selected'] = (array)$args['selected'];
    $r = wp_parse_args($args, $defaults);

    if (!isset( $r['pad_counts']) && $r['show_count']) {
        $r['pad_counts'] = true;
    }

    extract($r);

    $atts = array('hide_empty' => $hide_empty, 'hierarchical' => $hierarchical);
    $categories = get_terms($taxonomy, $atts);

    $name = esc_attr($name);
    $id = $id ? esc_attr($id) : $name;

    $output = '<select'.($css_style != '' ? ' style="'.$css_style.'"' : '').($multiple == 1 ? ' multiple' : '').' name="'.$name.'" id="'.$id.'" class"'.$css_class.'">';

    if (!empty($categories)) {
        $depth = $r['depth'];

        $output.= walk_category_dropdown_tree($categories, $depth, $r);
    }

    $output.= "</select>\n";

    if ($echo) {
        echo $output;
    }

    return $output;
}
