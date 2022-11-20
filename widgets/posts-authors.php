<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Posts_Authors extends d4p_widget_core {
    public $widget_base = 'd4p_clw_authors';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $excerpt_length = 20;

    public $defaults = array(
        'title' => 'Posts Authors',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-authors-plain',
        'post_types' => array('post'),
        'authors' => array(),
        'limit' => 5,
        'min_posts' => 1,
        'sort_column' => 'posts',
        'sort_order' => 'DESC',
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
        $this->widget_description = __("List of posts authors profiles.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Posts Authors", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('authors-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('authors-display')),
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

        $instance['show_avatar'] = isset($new_instance['show_avatar']);
        $instance['show_description'] = isset($new_instance['show_description']);
        $instance['show_recent'] = isset($new_instance['show_recent']);

        $instance['sort_column'] = strip_tags(stripslashes($new_instance['sort_column']));
        $instance['sort_order'] = $new_instance['sort_order'] == 'ASC' ? 'ASC' : 'DESC';
        $instance['template'] = strip_tags(stripslashes($new_instance['template']));

        $instance['limit'] = absint(strip_tags(stripslashes($new_instance['limit'])));
        $instance['min_posts'] = absint(strip_tags(stripslashes($new_instance['min_posts'])));
        $instance['avatar_size'] = absint(strip_tags(stripslashes($new_instance['avatar_size'])));
        $instance['recent_posts'] = absint(strip_tags(stripslashes($new_instance['recent_posts'])));

        if ($instance['limit'] < 1) {
            $instance['limit'] = 1;
        }

        if ($instance['min_posts'] < 1) {
            $instance['min_posts'] = 1;
        }

        $_post_types = (array)$new_instance['post_types'];
        $post_types = array();

        foreach ($_post_types as $cpt) {
            if (post_type_exists($cpt)) {
                $post_types[] = $cpt;
            }
        }

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

        $instance['post_types'] = $post_types;
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

    public function results($instance) {
        global $wpdb;

        $where = array(
            "p.post_status = 'publish'",
            "p.post_type IN ('".join("', '", $instance['post_types'])."')"
        );

        if (isset($instance['authors']['in']) && !empty($instance['authors']['in'])) {
            $where[] = "u.ID IN (".join(', ', $instance['authors']['in']).")";
        }

        if (isset($instance['authors']['out']) && !empty($instance['authors']['out'])) {
            $where[] = "u.ID NOT IN (".join(', ', $instance['authors']['in']).")";
        }

        $query = "SELECT u.ID as user_id, count(*) as posts FROM ".$wpdb->users." u INNER JOIN ".$wpdb->posts." p ";
        $query.= "ON p.post_author = u.ID WHERE ".join(" AND ", $where);
        $query.= "GROUP BY u.ID HAVING posts > ".$instance['min_posts']." ";
        $query.= "ORDER BY ".$instance['sort_column']." ".$instance['sort_order']." ";
        $query.= "LIMIT 0, ".$instance['limit'];

        return $wpdb->get_results($query);
    }

    public function render($results, $instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-authors');

        $tpl_path = gdclw_load_template($instance['template']);

        if (empty($results)) {
            echo '<p class="clw-nothing-found">';
            _e("No authors found.", "gd-clever-widgets");
            echo '</p>';
        } else {
            foreach ($results as $u) {
                $user_id = absint($u->user_id);
                $user_posts = absint($u->posts);

                $user = get_user_by('id', $user_id);

                include($tpl_path);
            }
        }
        
        echo gdclw_widget_render_footer($instance);
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
    }
}
