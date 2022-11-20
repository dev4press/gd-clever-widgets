<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Related_Posts extends d4p_widget_core {
    public $widget_base = 'd4p_clw_related_posts';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $excerpt_length = 20;

    public $defaults = array(
        'title' => 'Related Posts',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-posts-plain',
        'post_types' => array('post'),
        'limit' => 5,
        'thumbnail' => 'any',
        'sort_column' => 'ID',
        'sort_order' => 'DESC',
        'terms_relationship' => 'OR',
        'keywords_search' => 'auto',
        'keywords_limit' => 1,
        'excerpt_length' => 20,
        'template' => 'clw-posts-standard.php',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("List of related posts for current post or page.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Related Posts", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('related-content')),
            'filter' => array('name' => __("Filter", "gd-clever-widgets"), 'include' => array('related-filter', 'posts-filter')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('posts-display')),
            'extra' => array('name' => __("Extra", "gd-clever-widgets"), 'include' => array('shared-wrapper'))
        );

        include(GDCLW_PATH.'forms/widgets/shared-loader.php');
    }

    public function is_visible($instance) {
        return is_singular($instance['post_types']);
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_style'] = strip_tags(stripslashes($new_instance['_style']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['keywords_search'] = strip_tags(stripslashes($new_instance['keywords_search']));
        $instance['terms_relationship'] = strip_tags(stripslashes($new_instance['terms_relationship']));
        $instance['thumbnail'] = strip_tags(stripslashes($new_instance['thumbnail']));
        $instance['sort_column'] = strip_tags(stripslashes($new_instance['sort_column']));
        $instance['sort_order'] = strip_tags(stripslashes($new_instance['sort_order']));
        $instance['template'] = strip_tags(stripslashes($new_instance['template']));

        $instance['limit'] = intval(strip_tags(stripslashes($new_instance['limit'])));
        $instance['excerpt_length'] = intval(strip_tags(stripslashes($new_instance['excerpt_length'])));
        $instance['keywords_limit'] = intval(strip_tags(stripslashes($new_instance['keywords_limit'])));

        $_post_types = (array)$new_instance['post_types'];
        $post_types = array();

        foreach ($_post_types as $cpt) {
            if (post_type_exists($cpt)) {
                $post_types[] = $cpt;
            }
        }

        $instance['post_types'] = $post_types;

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

        $_obj = get_post();

        $args = array(
            'ignore_sticky_posts' => true,
            'orderby' => $instance['sort_column'],
            'order' => $instance['sort_order'],
            'posts_per_page' => $instance['limit'],
            'post_status' => 'publish',
            'post_type' => $_obj->post_type,
            'post__not_in' => array($_obj->ID),
            'tax_query' => array(),
            'meta_query' => array()
        );

        switch ($instance['thumbnail']) {
            case 'yes':
                $args['meta_query'] = array(
                    array(
                        'key' => '_thumbnail_id',
                        'compare' => 'EXISTS'
                    )
                );
                break;
            case 'no':
                $args['meta_query'] = array(
                    array(
                        'key' => '_thumbnail_id',
                        'compare' => 'NOT EXISTS'
                    )
                );
                break;
        }

        $relation = 0;

        $taxonomies = get_object_taxonomies($_obj->post_type, 'names');

        foreach ($taxonomies as $tax) {
            $terms = wp_get_post_terms($_obj->ID, $tax, array('fields' => 'ids'));

            if (!empty($terms)) {
                $relation++;

                $args['tax_query'][] = array(
                    'taxonomy' => $tax,
                    'field' => 'term_id',
                    'terms' => array_values($terms)
                );
            }
        }

        if ($relation > 1) {
            $args['tax_query']['relation'] = $instance['terms_relationship'];
        }

        if ($instance['keywords_search'] != 'off') {
            $_all = explode(' ', $_obj->post_title);
            $keywords = array();

            foreach ($_all as $word) {
                $word = trim($word);

                if (mb_strlen($word) > 3) {
                    $keywords[] = mb_strtolower($word);
                }
            }

            uasort($keywords, 'gdclw_length_sort');

            $keywords = array_slice($keywords, 0, $instance['keywords_limit']);

            if (!empty($keywords)) {
                $args['s'] = implode(' ', $keywords);
            }
        }

        $args = apply_filters('gdclw_widget_related_posts_query_args', $args, $instance, $_obj);

        return new WP_Query($args);
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-related gdclw-posts');

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
            echo '<p class="clw-nothing-found">';
            _e("No related posts found.", "gd-clever-widgets");
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
