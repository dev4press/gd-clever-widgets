<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Videos_Playlist extends d4p_widget_core {
    public $widget_base = 'd4p_clw_vidlist';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';
    public $cache_method = 'full';

    public $defaults = array(
        'title' => '',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        'videos' => array(),
        'show' => 'all',
        'limit' => 5,
        'order' => 'listed',
        'width' => 480,
        'height' => 360,
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Multiple embedable videos with random play.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Videos Playlist", "gd-clever-widgets");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function get_tabkey($tab) {
        $key = $this->get_field_id('tab-'.$tab);

        return str_replace(array('_', ' '), array('-', '-'), $key);
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-clever-widgets"), 'include' => array('shared-global', 'shared-display', 'shared-cache')),
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('vidlist-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('vidlist-display')),
            'extra' => array('name' => __("Extra", "gd-clever-widgets"), 'include' => array('shared-wrapper'))
        );

        include(GDCLW_PATH.'forms/widgets/shared-loader.php');
    }

    public function update($new_instance, $old_instance) {
        d4p_include('functions', 'admin', GDCLW_D4PLIB);

        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        $instance['_cached'] = intval(strip_tags(stripslashes($new_instance['_cached'])));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);

        $instance['width'] = intval(strip_tags(stripslashes($new_instance['width'])));
        $instance['height'] = intval(strip_tags(stripslashes($new_instance['height'])));
        $instance['limit'] = intval(strip_tags(stripslashes($new_instance['limit'])));
        $instance['show'] = strip_tags(stripslashes($new_instance['show']));
        $instance['order'] = strip_tags(stripslashes($new_instance['order']));

        $videos = array();
        $instance['videos'] = array();
        if (isset($new_instance['videos'])) {
            $videos = d4p_split_textarea_to_list($new_instance['videos']);
        }

        foreach ($videos as $video) {
            if (d4p_is_oembed_link($video)) {
                $instance['videos'][] = $video;
            }
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

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-videos-playlist');

        if ($instance['order'] == 'reversed') {
            $instance['videos'] = array_reverse($instance['videos']);
        } else if ($instance['order'] == 'random') {
            shuffle($instance['videos']);
        }

        if ($instance['show'] == 'limit') {
            $instance['videos'] = array_slice($instance['videos'], 0, $instance['limit']);
        }

        $i = 0;
        foreach ($instance['videos'] as $url) {
            $class = 'clw-video-single clw-video-'.$i;

            echo '<div class="'.$class.'">';
            echo wp_oembed_get($url, array('width' => $instance['width'], 'height' => $instance['height']));
            echo '</div>';

            $i++;
        }

        echo gdclw_widget_render_footer($instance);
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
    }
}
