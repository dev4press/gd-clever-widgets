<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Enhanced_Calendar extends d4p_widget_core {
    public $widget_base = 'd4p_clw_calendar';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $defaults = array(
        'title' => '',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-calendar-clean',
        'post_type' => array('post'),
        'days_titles' => 'date_counts',
        'weekdays' => 'initials',
        'content' => 'auto',
        'date_month' => 1,
        'date_year' => 2015,
        'table_id' => 'calendar',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Ultimate date archive calendar widget.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Enhanced Calendar", "gd-clever-widgets");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function get_tabkey($tab) {
        $key = $this->get_field_id('tab-'.$tab);

        return str_replace(array('_', ' '), array('-', '-'), $key);
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-clever-widgets"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('calendar-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('calendar-display')),
            'extra' => array('name' => __("Extra", "gd-clever-widgets"), 'include' => array('shared-wrapper'))
        );

        include(GDCLW_PATH.'forms/widgets/shared-loader.php');
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_style'] = strip_tags(stripslashes($new_instance['_style']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['table_id'] = strip_tags(stripslashes($new_instance['table_id']));
        $instance['days_titles'] = strip_tags(stripslashes($new_instance['days_titles']));
        $instance['weekdays'] = strip_tags(stripslashes($new_instance['weekdays']));
        $instance['content'] = strip_tags(stripslashes($new_instance['content']));

        $instance['date_month'] = intval(strip_tags(stripslashes($new_instance['date_month'])));
        $instance['date_year'] = intval(strip_tags(stripslashes($new_instance['date_year'])));

        if (isset($new_instance['post_type'])) {
            $instance['post_type'] = (array)$new_instance['post_type'];
        } else {
            $instance['post_type'] = array('post');
        }

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['before'])));
            $instance['after'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['after'])));
        }

        return $instance;
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-calendar');

        require_once(GDCLW_PATH.'core/code/calendar.php');

        $args = array(
            'post_type' => $instance['post_type'],
            'table_id' => $instance['table_id'],
            'days_titles' => $instance['days_titles'],
            'weekdays' => $instance['weekdays'],
            'content' => $instance['content'],
            'date_month' => $instance['date_month'],
            'date_year' => $instance['date_year']
        );

        gdclw_calendar($args);

        echo gdclw_widget_render_footer($instance);
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
    }
}
