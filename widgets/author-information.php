<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Author_Information extends d4p_widget_core {
    public $widget_base = 'd4p_clw_authorinfo';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $excerpt_length = 20;

    public $defaults = array(
        'title' => 'Author',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-authors-plain',
        'method' => 'auto',
        'author' => 1,
        'show_avatar' => true,
        'show_description' => false,
        'show_recent' => false,
        'avatar_size' => 96,
        'recent_posts' => 3,
        'template' => 'clw-authors-standard.php',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Post author profile information.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Author Information", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('author-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('authors-display')),
            'extra' => array('name' => __("Extra", "gd-clever-widgets"), 'include' => array('shared-wrapper'))
        );

        include(GDCLW_PATH.'forms/widgets/shared-loader.php');
    }

    public function is_visible($instance) {
        return ($instance['method'] == 'auto' && is_singular()) || $instance['method'] == 'select';
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_style'] = strip_tags(stripslashes($new_instance['_style']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['method'] = strip_tags(stripslashes($new_instance['method']));
        $instance['author'] = absint(strip_tags(stripslashes($new_instance['author'])));

        $instance['show_avatar'] = isset($new_instance['show_avatar']);
        $instance['show_description'] = isset($new_instance['show_description']);
        $instance['show_recent'] = isset($new_instance['show_recent']);

        $instance['template'] = strip_tags(stripslashes($new_instance['template']));

        $instance['avatar_size'] = absint(strip_tags(stripslashes($new_instance['avatar_size'])));
        $instance['recent_posts'] = absint(strip_tags(stripslashes($new_instance['recent_posts'])));

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

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-author');

        $tpl_path = gdclw_load_template($instance['template']);

        $u = null;

        if ($instance['method'] == 'auto') {
            global $post;

            $u = $post->post_author;
        } else {
            $u = $instance['author'];
        }

        if (!is_null($u)) {
            $user_id = absint($u);
            $user_posts = count_user_posts($u);

            $user = get_user_by('id', $user_id);

            include($tpl_path);
        }

        echo gdclw_widget_render_footer($instance);
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
	}
}
