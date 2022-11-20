<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Enhanced_Cloud extends d4p_widget_core {
    public $_internal_posts = 0;

    public $widget_base = 'd4p_clw_cloud';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';
    public $cache_method = 'full';

    public $defaults = array(
        'title' => 'Terms Cloud',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'smallest' => 10,
        'largest' => 20,
        'unit' => 'px',
        'show_counts' => 'no',
        'number' => 45,
        'posts' => 1,
        'select' => 'count',
        'select_order' => 'DESC',
        'taxonomies' => array('post_tag'),
        'exclude' => array(),
        'order' => 'ASC',
        'orderby' => 'name',
        'separator' => ' ',
        'prefix' => '',
        'suffix' => '',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Powerful Tag Cloud replacement.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Enhanced Term Cloud", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('cloud-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('cloud-display')),
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

        $instance['smallest'] = intval(strip_tags(stripslashes($new_instance['smallest'])));
        $instance['largest'] = intval(strip_tags(stripslashes($new_instance['largest'])));
        $instance['number'] = intval(strip_tags(stripslashes($new_instance['number'])));
        $instance['posts'] = intval(strip_tags(stripslashes($new_instance['posts'])));

        $instance['unit'] = strip_tags(stripslashes($new_instance['unit']));
        $instance['show_counts'] = strip_tags(stripslashes($new_instance['show_counts']));
        $instance['select'] = strip_tags(stripslashes($new_instance['select']));
        $instance['select_order'] = strip_tags(stripslashes($new_instance['select_order']));
        $instance['order'] = strip_tags(stripslashes($new_instance['order']));
        $instance['orderby'] = strip_tags(stripslashes($new_instance['orderby']));

        $instance['taxonomies'] = array('post_tag');

        if (isset($new_instance['taxonomies']) && !empty($new_instance['taxonomies'])) {
            $instance['taxonomies'] = (array)$new_instance['taxonomies'];
        }

        $instance['exclude'] = array();

        if (!empty($new_instance['exclude'])) {
            $terms = explode(',', $new_instance['exclude']);
            $terms = array_unique($terms);
            $terms = array_filter($terms);

            if (!empty($terms)) {
                $instance['exclude'] = $terms;
            }
        }

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];

            $instance['separator'] = $new_instance['separator'];
            $instance['prefix'] = $new_instance['prefix'];
            $instance['suffix'] = $new_instance['suffix'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['before'])));
            $instance['after'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['after'])));

            $instance['separator'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['separator'])));
            $instance['prefix'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['prefix'])));
            $instance['suffix'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['suffix'])));
        }

        return $instance;
    }

    public function terms_clauses($pieces) {
        $pieces['where'].= ' AND tt.count >= '.$this->_internal_posts;

        return $pieces;
    }

    public function results($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $this->_internal_posts = $instance['posts'];
        
        $args = array(
            'orderby' => $instance['select'], 
            'order' => $instance['select_order'],
            'number' => $instance['number'],
            'hierarchical' => false,
            'hide_empty' => false
        );

        add_filter('terms_clauses', array($this, 'terms_clauses'));

        $terms = get_terms($instance['taxonomies'], $args);

        remove_filter('terms_clauses', array($this, 'terms_clauses'));

        return $terms;
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $terms = array();

        foreach ($results as $term) {
            $term->id = $term->term_id;
            $term->link = get_term_link($term, $term->taxonomy);

            if ($instance['show_counts'] == 'yes') {
                $term->name.= ' ('.$term->count.')';
            }

            $terms[] = $term;
        }

        if ($instance['orderby'] == 'RAND') {
            $instance['order'] = $instance['orderby'];
        }

        $args = array(
            'smallest' => $instance['smallest'], 
            'largest' => $instance['largest'], 
            'unit' => $instance['unit'],
            'format' => 'array',
            'orderby' => $instance['orderby'], 
            'order' => $instance['order']
        );

        $cloud = wp_generate_tag_cloud($terms, $args);

        if ($instance['prefix'] != '' || $instance['suffix'] != '') {
            foreach ($cloud as $key => $c) {
                $cloud[$key] = $instance['prefix'].$c.$instance['suffix'];
            }
        }

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-cloud');

        echo join($instance['separator'], $cloud);

        echo gdclw_widget_render_footer($instance);
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
    }
}
