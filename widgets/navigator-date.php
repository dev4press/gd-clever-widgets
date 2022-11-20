<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Navigator_Date extends d4p_widget_core {
    public $widget_base = 'd4p_clw_navdate';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $defaults = array(
        'title' => 'Date Archives',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-navigator-elegant',
        'dummy_data' => 'no',
        'root_content' => 'full',
        'root_detect_top' => 'no',
        'sort_order' => 'DESC',
        'archives' => 'yearly-monthly-daily',
        'level_first' => 6,
        'level_inner' => 12,
        'decade_links' => 'none',
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
        $this->widget_description = __("AJAX powered navigation for date based archives.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Date Archives Navigator", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('navdate-content')),
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
        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        //$instance['_cached'] = intval(strip_tags(stripslashes($new_instance['_cached'])));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_style'] = strip_tags(stripslashes($new_instance['_style']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['root_content'] = strip_tags(stripslashes($new_instance['root_content']));
        $instance['sort_order'] = strip_tags(stripslashes($new_instance['sort_order']));
        $instance['archives'] = strip_tags(stripslashes($new_instance['archives']));
        $instance['level_first'] = intval(strip_tags(stripslashes($new_instance['level_first'])));
        $instance['level_inner'] = intval(strip_tags(stripslashes($new_instance['level_inner'])));
        $instance['decade_links'] = strip_tags(stripslashes($new_instance['decade_links']));
        $instance['post_counts'] = strip_tags(stripslashes($new_instance['post_counts']));
        $instance['animate_method'] = strip_tags(stripslashes($new_instance['animate_method']));
        $instance['animate_speed'] = intval(strip_tags(stripslashes($new_instance['animate_speed'])));
        $instance['mark_current'] = strip_tags(stripslashes($new_instance['mark_current']));
        $instance['root_detect_top'] = strip_tags(stripslashes($new_instance['root_detect_top']));
        $instance['dummy_data'] = isset($new_instance['dummy_data']) ? strip_tags(stripslashes($new_instance['dummy_data'])) : 'no';

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses($new_instance['before']));
            $instance['after'] = stripslashes(wp_filter_post_kses($new_instance['after']));
        }

        $instance['markup_plus'] = $new_instance['markup_plus'];
        $instance['markup_minus'] = $new_instance['markup_minus'];
        $instance['markup_up'] = $new_instance['markup_up'];
        $instance['markup_more'] = $new_instance['markup_more'];
        $instance['markup_wait'] = $new_instance['markup_wait'];

        return $instance;
    }

    public function init() {
        require_once(GDCLW_PATH.'core/code/navigator.php');
    }

    public function draw_level($instance, $args = array()) {
        $defaults = array('value' => '', 'level' => 0, 'offset' => 0, 'current' => '');
        $args = wp_parse_args($args, $defaults);

        $levels = explode('-', $instance['archives']);
        $archive = explode('-', $args['value']);
        $level = intval($args['level']);
        $parent = $level;

        $arc_level = '';
        switch (count($archive)) {
            case 1:
                $arc_level = 'decennially';
                break;
            case 2:
                $arc_level = 'yearly';
                break;
            case 3:
                $arc_level = 'monthly';
                break;
            case 4:
                $arc_level = 'daily';
                break;
        }

        $id = array_search($arc_level, $levels);

        if ($id !== false) {
            if (isset($levels[$id + 1])) {
                $parent = $id + 1;
            } else {
                $parent = $id;
            }
        }
        
        $last_level = (count($levels) - 1) == $parent;

        $instance = apply_filters('gdclw_widget_arguments_date_archives', $instance, $this->widget_id, $level, $archive);

        $atts = array('type' => $levels[$parent], 'decade' => $archive[0], 
                      'sort_order' => $instance['sort_order'], 'decade_url' => $instance['decade_links']);

        if (isset($archive[1])) {
            $atts['year'] = $archive[1];
        }

        if (isset($archive[2])) {
            $atts['month'] = $archive[2];
        }

        if ($instance['dummy_data'] == 'yes' && gdclw_settings()->navigator_dummy_data_mode) {
            require_once(GDCLW_PATH.'core/code/dummy.php');
            $list = gdclw_dummy_get_date_archives($atts);
        } else {
            $list = gdclw_get_date_archives($atts);
        }

        $rargs = array('level' => $level, 'dig_deep' => !$last_level,
                       'current' => $args['current'], 'widget_name' => 'date_archives');

        return gdclw_render_list_level($list, $this->id, $instance, $rargs);
    }

    public function results($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $instance = apply_filters('gdclw_widget_arguments_date_archives_zero', $instance, $this->widget_id);

        $levels = explode('-', $instance['archives']);

        $last_level = false; $_year = ''; $_month = '';
        $parent = $levels[0]; $show_top = false; $up_element = null;
        if (isset($instance['root_content'])) {
            if ($instance['root_content'] == 'detect') {
                if (is_date()) {
                    $level = is_year() ? 'yearly' : (is_month() ? 'monthly' : (is_day() ? 'daily' : ''));
                    $id = array_search($level, $levels);

                    if ($id !== false) {
                        if (isset($levels[$id + 1])) {
                            $id++;
                            $parent = $levels[$id];
                        } else {
                            $parent = $levels[$id];
                            $last_level = true;
                        }

                        $last_level = (count($levels) - 1) == $id;
                        $show_top = $instance['root_detect_top'] == 'yes';

                        $current = explode('-', gdclw_plugin()->navigator['page']);

                        if (isset($current[0])) {
                            $_year = $current[0];
                        }

                        if (isset($current[1])) {
                            $_month = $current[1];
                        }

                    }
                }
            }
        }

        if ($show_top) {
            $up_element = gdclw_get_parent_date_item($instance);
        }

        $atts = array('type' => $parent, 'year' => $_year, 'month' => $_month, 'sort_order' => $instance['sort_order'], 'decade_url' => $instance['decade_links']);

        if ($instance['dummy_data'] == 'yes' && gdclw_settings()->navigator_dummy_data_mode) {
            require_once(GDCLW_PATH.'core/code/dummy.php');
            $list = gdclw_dummy_get_date_archives($atts);
        } else {
            $list = gdclw_get_date_archives($atts);
        }

        $rargs = array('dig_deep' => !$last_level, 'parent' => $parent, 
                       'init' => true, 'current' => gdclw_plugin()->navigator['page'],
                       'widget_name' => 'date_archives', 'up' => $up_element);

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
