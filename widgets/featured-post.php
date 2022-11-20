<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Featured_Post extends d4p_widget_core {
    public $widget_base = 'd4p_clw_featured';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';
    public $cache_method = 'full';

    public $excerpt_length = 20;

    public $defaults = array(
        'title' => 'Featured Post',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-posts-plain',
        'post' => 0,
        'excerpt_length' => 20,
        'template' => 'clw-posts-standard.php',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Selected featured post or page.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Featured Post", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('featured-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('featured-display')),
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
        $instance['_style'] = strip_tags(stripslashes($new_instance['_style']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['template'] = strip_tags(stripslashes($new_instance['template']));

        $instance['post'] = intval(strip_tags(stripslashes($new_instance['post'])));
        $instance['excerpt_length'] = intval(strip_tags(stripslashes($new_instance['excerpt_length'])));

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['before'])));
            $instance['after'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['after'])));
        }

        return $instance;
    }

    public function set_excerpt_length($length) {
        return $this->excerpt_length;
    }

    public function results($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());
        
        $args = array(
            'posts_per_page' => 1,
            'post__in' => array(intval($instance['post'])),
            'post_type' => 'any'
        );

        return new WP_Query($args);
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-posts');

        $tpl_path = gdclw_load_template($instance['template']);

        if ($instance['excerpt_length'] > 0) {
            $this->excerpt_length = $instance['excerpt_length'];
            add_filter('excerpt_length', array($this, 'set_excerpt_length'), 9999);
        }

        if ($results->have_posts()) :
            while ($results->have_posts()) : $results->the_post();
                include($tpl_path);
            endwhile;
        else :
            echo '<p class="clw-no-posts-found">';
            _e("No posts found for this widget.", "gd-clever-widgets");
            echo '</p>';
        endif;

        wp_reset_postdata();

        if ($instance['excerpt_length'] > 0) {
            remove_filter('excerpt_length', array($this, 'set_excerpt_length'), 9999);
        }

        echo gdclw_widget_render_footer($instance);
    }

    public function widget( $args, $instance ) {
	    parent::widget( $args, $instance );

	    gdclw_plugin()->load_css();
    }
}
