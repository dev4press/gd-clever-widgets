<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Enhanced_Meta extends d4p_widget_core {
    public $widget_base = 'd4p_clw_meta';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $defaults = array(
        'title' => 'Meta',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => '',
        'auth_login' => true,
        'auth_register' => true,
        'auth_logout' => true,
        'auth_wpadmin' => true,
        'auth_profile' => false,
        'rss_entries' => true,
        'rss_comments' => true,
        'link_wordpress' => true,
        'link_dev4press' => true,
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Login, Logout, RSS and other links.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Enhanced Meta", "gd-clever-widgets");

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
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('meta-content')),
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
        $instance['_style'] = strip_tags(stripslashes($new_instance['_style']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['auth_login'] = isset($new_instance['auth_login']);
        $instance['auth_register'] = isset($new_instance['auth_register']);
        $instance['auth_logout'] = isset($new_instance['auth_logout']);
        $instance['auth_wpadmin'] = isset($new_instance['auth_wpadmin']);
        $instance['auth_profile'] = isset($new_instance['auth_profile']);

        $instance['rss_entries'] = isset($new_instance['rss_entries']);
        $instance['rss_comments'] = isset($new_instance['rss_comments']);
        $instance['link_wordpress'] = isset($new_instance['link_wordpress']);
        $instance['link_dev4press'] = isset($new_instance['link_dev4press']);

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

        echo gdclw_widget_render_header($instance, $this->widget_base, 'gdclw-ehanced-meta');

        $lists = array(
            array(),
            array(),
            array()
        );

        if (is_user_logged_in()) {
            if ($instance['auth_wpadmin']) {
                $lists[0][] = '<a href="'.admin_url().'">'.__("Site Admin", "gd-clever-widgets").'</a>';
            }

            if ($instance['auth_profile']) {
                $lists[0][] = '<a href="'.admin_url('profile.php').'">'.__("Profile", "gd-clever-widgets").'</a>';
            }

            if ($instance['auth_logout']) {
                $lists[0][] = '<a href="'.  wp_logout_url().'">'.__("Log Out", "gd-clever-widgets").'</a>';
            }
        } else {
            if ($instance['auth_login']) {
                $lists[0][] = '<a href="'.wp_login_url().'">'.__("Log In", "gd-clever-widgets").'</a>';
            }

            if ($instance['auth_register']) {
                $lists[0][] = '<a href="'.wp_registration_url().'">'.__("Register", "gd-clever-widgets").'</a>';
            }
        }

        if ($instance['rss_entries']) {
            $lists[1][] = '<a href="'.get_bloginfo('rss2_url').'">'.__("Entries <abbr title='Really Simple Syndication'>RSS</abbr>", "gd-clever-widgets").'</a>';
        }

        if ($instance['rss_comments']) {
            $lists[1][] = '<a href="'.get_bloginfo('comments_rss2_url').'">'.__("Comments <abbr title='Really Simple Syndication'>RSS</abbr>", "gd-clever-widgets").'</a>';
        }

        if ($instance['link_wordpress']) {
            $lists[2][] = '<a href="http://wordpress.org/">WordPress.org</a>';
        }

        if ($instance['link_dev4press']) {
            $lists[2][] = '<a href="https://www.dev4press.com/">dev4Press.com</a>';
        }

        $lists[0] = apply_filters('gdclw_widget_meta_list_auth', $lists[0]);
        $lists[1] = apply_filters('gdclw_widget_meta_list_rss', $lists[1]);
        $lists[2] = apply_filters('gdclw_widget_meta_list_links', $lists[2]);

        $output = array();
        if (!empty($lists[0])) {
            $output[] = '<ul><li>'.join('</li><li>', $lists[0]).'</li></ul>';
        }

        if (!empty($lists[1])) {
            $output[] = '<ul><li>'.join('</li><li>', $lists[1]).'</li></ul>';
        }

        if (!empty($lists[2])) {
            $output[] = '<ul><li>'.join('</li><li>', $lists[2]).'</li></ul>';
        }

        echo join('<hr/>', $output);

        echo gdclw_widget_render_footer($instance);
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
    }
}
