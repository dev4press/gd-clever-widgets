<?php

if (!defined('ABSPATH')) { exit; }

class d4pclwWidget_Navigator_Menu extends d4p_widget_core {
    public $widget_base = 'd4p_clw_navmenu';
    public $widget_domain = 'd4pclw_widgets';
    public $cache_prefix = 'd4pclw';

    public $defaults = array(
        'title' => 'Menu Navigator',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_class' => '',
        '_tab' => 'global',
        '_style' => 'clw-navigator-elegant',
        'dummy_data' => 'no',
        'nav_menu' => '',
        'root_item' => -1,
        'root_content' => 'full',
        'root_custom_top' => 'no',
        'root_detect_top' => 'no',
        'level_first' => 12,
        'level_inner' => 12,
        'show_description' => 'no',
        'animate_method' => 'slideDown',
        'animate_speed' => 300,
        'mark_current' => 'mark',
        'markup_plus' => '&#9658;',
        'markup_minus' => '&#9660;',
        'markup_up' => '&#9650;',
        'markup_more' => 'Show More',
        'markup_wait' => 'Please Wait...',
        'before' => '',
        'after' => ''
    );

    public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("AJAX powered navigation for menus.", "gd-clever-widgets");
        $this->widget_name = __("Clever", "gd-clever-widgets").': '.__("Menu Navigator", "gd-clever-widgets");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function get_tabkey($tab) {
        $key = $this->get_field_id('tab-'.$tab);

        return str_replace(array('_', ' '), array('-', '-'), $key);
    }

    function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-clever-widgets"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-clever-widgets"), 'include' => array('navmenu-content')),
            'display' => array('name' => __("Display", "gd-clever-widgets"), 'include' => array('navigator-display')),
            'markup' => array('name' => __("Markup", "gd-clever-widgets"), 'include' => array('shared-markup')),
            'extra' => array('name' => __("Extra", "gd-clever-widgets"), 'include' => array('shared-wrapper'))
        );

        if (gdclw_settings()->navigator_dummy_data_mode) {
            $_tabs['dev'] = array('name' => __("DEV", "gd-clever-widgets"), 'include' => array('shared-dev'));
        }

        include(GDCLW_PATH.'forms/widgets/shared-loader.php');
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        //$instance['_cached'] = intval(strip_tags(stripslashes($new_instance['_cached'])));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_style'] = strip_tags(stripslashes($new_instance['_style']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));

        $instance['nav_menu'] = strip_tags(stripslashes($new_instance['nav_menu']));
	    $instance['root_item'] = intval(strip_tags(stripslashes($new_instance['root_item'])));
        $instance['root_content'] = strip_tags(stripslashes($new_instance['root_content']));
        $instance['level_first'] = intval(strip_tags(stripslashes($new_instance['level_first'])));
        $instance['level_inner'] = intval(strip_tags(stripslashes($new_instance['level_inner'])));
        $instance['animate_method'] = strip_tags(stripslashes($new_instance['animate_method']));
        $instance['animate_speed'] = intval(strip_tags(stripslashes($new_instance['animate_speed'])));
        $instance['mark_current'] = strip_tags(stripslashes($new_instance['mark_current']));
        $instance['show_description'] = strip_tags(stripslashes($new_instance['show_description']));
        $instance['root_custom_top'] = strip_tags(stripslashes($new_instance['root_custom_top']));
        $instance['root_detect_top'] = strip_tags(stripslashes($new_instance['root_detect_top']));
        $instance['dummy_data'] = isset($new_instance['dummy_data']) ? strip_tags(stripslashes($new_instance['dummy_data'])) : 'no';

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['before'])));
            $instance['after'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['after'])));
        }

        $instance['markup_plus'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_plus'])));
        $instance['markup_minus'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_minus'])));
        $instance['markup_up'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_up'])));
        $instance['markup_more'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_more'])));
        $instance['markup_wait'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['markup_wait'])));

        return $instance;
    }

    public function init() {
        require_once(GDCLW_PATH.'core/code/navigator.php');
    }

    public function draw_level($instance, $args = array()) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $defaults = array('value' => '', 'level' => 0, 'offset' => 0, 'current' => '', 'current_url' => '');
        $args = wp_parse_args($args, $defaults);

        $level = intval($args['level']);
        $parent = intval($args['value']);

        $instance = apply_filters('gdclw_widget_arguments_nav_menu', $instance, $this->widget_id, 0, $parent, 0);

        $atts = array('name' => $instance['nav_menu'], 'parent' => $parent);

        if ($instance['dummy_data'] == 'yes' && gdclw_settings()->navigator_dummy_data_mode) {
            require_once(GDCLW_PATH.'core/code/dummy.php');
            $list = gdclw_dummy_get_nav_menu_items($atts);
        } else {
            $list = gdclw_get_nav_menu_items($atts);
        }

        $rargs = array('level' => $level, 'dig_deep' => null, 'total_count' => count($list['items']),
                       'parent' => $parent, 'current' => $args['current_url'], 'widget_name' => 'nav_menu');

        return gdclw_render_list_level($list['items'], $this->id, $instance, $rargs);
    }

    public function results($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $instance = apply_filters('gdclw_widget_arguments_nav_menu_zero', $instance, $this->widget_id);

        $parent = 0; $show_top = false; $up_element = null; $detect = false;
        if (isset($instance['root_content'])) {
            if ($instance['root_content'] == 'custom') {
                if (isset($instance['root_item']) && $instance['root_item'] > 0) {
                    $parent = $instance['root_item'];

                    $show_top = $instance['root_custom_top'] == 'yes';
                }
            } else if ($instance['root_content'] == 'detect') {
                $detect = true;

                $show_top = $instance['root_detect_top'] == 'yes';
            }
        }

        $atts = array('name' => $instance['nav_menu'], 'parent' => $parent, 'show_top' => $show_top, 'detect' => $detect);

        if ($instance['dummy_data'] == 'yes' && gdclw_settings()->navigator_dummy_data_mode) {
            require_once(GDCLW_PATH.'core/code/dummy.php');
            $list = gdclw_dummy_get_nav_menu_items($atts);
        } else {
            $list = gdclw_get_nav_menu_items($atts);
        }

        $rargs = array('dig_deep' => null, 'total_count' => count($list['items']), 'parent' => $parent, 
                       'init' => true, 'current' => gdclw_plugin()->navigator['url'],
                       'widget_name' => 'nav_menu', 'up' => $list['up']);

        return gdclw_render_list_level($list['items'], $this->id, $instance, $rargs);
    }

    public function render($results, $instance) {
        $render = gdclw_widget_render_header($instance, $this->widget_base);

        if (empty($results)) {
            $render.= '<div class="clw-no-results">';
            $render.= __("There are no results for current widget settings.", "gd-clever-widgets");
            $render.= '</div>';
        } else {
            $render.= '<ul class="clw-top-level">'.$results.'</ul>';
        }

        $render.= gdclw_widget_render_footer($instance);

        echo $render;
    }

	public function widget( $args, $instance ) {
		parent::widget( $args, $instance );

		gdclw_plugin()->load_css();
	    gdclw_plugin()->load_js();
    }
}

function gdclw_render_dropdown_menu($args) {
    require_once(GDCLW_PATH.'core/code/walkers.php');

    if (!is_array($args)) {
        $args = array('menu' => $args);
    }

    $args['walker'] = new gdclw_Walker_DropDown_NavMenu();
    $args['items_wrap'] = '<select name="'.$args['menu_name'].'" id="%1$s" class="%2$s dropdown-menu">%3$s</select>';
    $args['indent_string'] = '&ndash; ';
    $args['indent_after'] =  '';

    return wp_nav_menu($args);
}
