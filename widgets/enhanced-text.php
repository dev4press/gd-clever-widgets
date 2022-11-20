<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Enhanced_Text extends d4p_widget_core {
    public $widget_base = 'd4p_clw_text';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $defaults = array(
        'title' => '',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'content' => '',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Arbitrary text or HTML, enhanced to allow PHP.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Enhanced Text", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('enhanced-text')),
            'extra' => array('name' => __("Extra", "gd-clever-widgets"), 'include' => array('shared-wrapper'))
        );

        include(GDCLW_PATH.'forms/widgets/shared-loader.php');
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        $instance['_cached'] = intval(strip_tags(stripslashes($new_instance['_cached'])));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        if (current_user_can('unfiltered_html')) {
            $instance['content'] = $new_instance['content'];
        } else {
            $instance['content'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['content'])));
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

        $class = array('gd-clever-widget', 'clw-enhanced-text');

        if (isset($instance['_class']) && $instance['_class'] != '') {
            $class[] = $instance['_class'];
        }

        $content = $this->eval_php($instance['content']);

        $render = '<div class="'.join(' ', $class).'">'.D4P_EOL;
        $render.= do_shortcode($content);
        $render.= '</div>';

        echo $render;
    }

    function eval_php($content) {
        ob_start();

        eval('?>'.$content);
        $text = ob_get_contents();
        ob_end_clean();

        return $text;
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
    }
}
