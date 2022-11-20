<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Enhanced_Posts extends d4p_widget_core {
    public $widget_base = 'd4p_clw_posts';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';
    public $cache_method = 'full';

    public $excerpt_length = 20;

    public $defaults = array(
        'title' => 'Posts',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-posts-plain',
        'limit' => 5,
        'filter' => 'post_type',
        'post_type' => 'post',
        'post_ids' => '',
        'terms' => array(),
        'authors' => array(),
        'thumbnail' => 'any',
        'sort_column' => 'ID',
        'sort_order' => 'DESC',
        'excerpt_length' => 20,
        'template' => 'clw-posts-standard.php',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Ultimate posts display widget.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Enhanced Posts", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('posts-content')),
            'filter' => array('name' => __("Filter", "gd-clever-widgets"), 'include' => array('posts-filter')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('posts-display')),
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

        $instance['filter'] = strip_tags(stripslashes($new_instance['filter']));
        $instance['post_type'] = strip_tags(stripslashes($new_instance['post_type']));
        $instance['post_ids'] = strip_tags(stripslashes($new_instance['post_ids']));
        $instance['thumbnail'] = strip_tags(stripslashes($new_instance['thumbnail']));
        $instance['sort_column'] = strip_tags(stripslashes($new_instance['sort_column']));
        $instance['sort_order'] = strip_tags(stripslashes($new_instance['sort_order']));
        $instance['template'] = strip_tags(stripslashes($new_instance['template']));

        $instance['limit'] = intval(strip_tags(stripslashes($new_instance['limit'])));
        $instance['excerpt_length'] = intval(strip_tags(stripslashes($new_instance['excerpt_length'])));

        $authors = array();
        $dupes = array();

        if (isset($new_instance['authors'])) {
            foreach ($new_instance['authors'] as $operator => $values) {
                foreach ($values as $value) {
                    if ($value != '') {
                        $user = get_user_by('login', $value);

                        if ($user && !in_array($user->ID, $dupes)) {
                            $authors[$operator][] = $user->ID;
                            $dupes[] = $user->ID;
                        }
                    }
                }
            }
        }

        $terms = array();
        $dupes = array();

        if (isset($new_instance['terms'])) {
            foreach ($new_instance['terms'] as $tax => $data) {
                foreach ($data as $operator => $values) {
                    foreach ($values as $value) {
                        if ($value != '') {
                            $term = get_term_by('name', $value, $tax);

                            if ($term && !in_array($term->term_id, $dupes)) {
                                $terms[$tax][$operator][] = $term->term_id;
                                $dupes[] = $term->term_id;
                            }
                        }
                    }
                }
            }
        }

        $instance['terms'] = $terms;
        $instance['authors'] = $authors;

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
            'ignore_sticky_posts' => true,
            'orderby' => $instance['sort_column'],
            'order' => $instance['sort_order'],
            'posts_per_page' => $instance['limit']
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

        switch ($instance['filter']) {
            case 'post_type':
                if (isset($instance['authors']['out']) && !empty($instance['authors']['out'])) {
                    $args['author__not_in'] = $instance['authors']['out'];
                }

                if (!isset($args['author__not_in']) && isset($instance['authors']['in']) && !empty($instance['authors']['in'])) {
                    $args['author__in'] = $instance['authors']['in'];
                }

                $args['post_type'] = $instance['post_type'];

                $tax_query = array();
                foreach ($instance['terms'] as $tax => $data) {
                    $raw = array('IN' => array(), 'NOT IN' => array());

                    foreach ($data as $operator => $terms) {
                        if (!empty($terms)) {
                            $op = $operator == 'in' ? 'IN' : 'NOT IN';
                            $raw[$op] = $terms;
                        }
                    }

                    foreach ($raw as $operator => $terms) {
                        if (!empty($terms)) {
                            $tax_query[] = array(
                                'taxonomy' => $tax,
                                'field' => 'id',
                                'terms' => $terms,
                                'operator' => $operator
                            );
                        }
                    }
                }

                if (!empty($tax_query)) {
                    $args['tax_query'] = $tax_query;
                }

                break;
            case 'post_ids':
                $args['post__in'] = $instance['post_ids'];
                $args['post_type'] = 'any';
                break;
        }

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
            echo '<p class="clw-nothing-found">';
            _e("No posts found.", "gd-clever-widgets");
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
