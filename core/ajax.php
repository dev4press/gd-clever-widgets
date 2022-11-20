<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_ajax_core {
    public $widgets = array(
        'd4p_clw_navdate' => 'd4pclwWidget_Navigator_Date',
        'd4p_clw_navmenu' => 'd4pclwWidget_Navigator_Menu',
        'd4p_clw_navpages' => 'd4pclwWidget_Navigator_Pages',
        'd4p_clw_navterms' => 'd4pclwWidget_Navigator_Terms'
    );

    public function __construct() {
        add_action('wp_ajax_gdclw_author_search', array($this, 'gdclw_author_search'));

        add_action('wp_ajax_gdclw_convert_currency_google', array($this, 'convert_currency_google'));
        add_action('wp_ajax_nopriv_gdclw_convert_currency_google', array($this, 'convert_currency_google'));

        add_action('wp_ajax_gdclw_navigator_request', array($this, 'navigator_request'));
        add_action('wp_ajax_nopriv_gdclw_navigator_request', array($this, 'navigator_request'));
    }

    public function gdclw_author_search() {
        global $wpdb;

        $s = d4p_sanitize_basic($_GET['q']);

        if (strlen($s) < 2) {
            wp_die();
        }

        $query = "SELECT u.user_login, count(*) AS posts FROM ".$wpdb->users." u INNER JOIN ".$wpdb->posts." p ";
        $query.= "ON p.post_author = u.ID WHERE u.user_login LIKE '%".esc_sql($s)."%' ";
        $query.= "GROUP BY u.ID ORDER BY posts DESC";

        $results = $wpdb->get_results($query);
        $users = array();

        foreach ($results as $row) {
            $users[] = $row->user_login;
        }

        echo implode("\n", $users)."\n";
	    wp_die();
    }

    public function convert_currency_google() {
        $data = $_POST;

        $result = array('status' => 'ok');

        $from = isset($_POST['from']) ? $_POST['from'] : '';
        $to = isset($_POST['to']) ? $_POST['to'] : '';

        if ($from != '' && $to != '' && strlen($from) == 3 && strlen($to) == 3) {
            require(GDCLW_PATH.'d4punits/d4p.units.php');

            $converted = d4p_units()->convert('currency_google', 1, $from, $to);
            
            if (is_null($converted)) {
                $converted = 0;
            }

            $result['values'] = array(
                $from.$to => $converted,
                $to.$from => $converted != 0 ? 1 / $converted : 0
            );
        } else {
            $result['status'] = 'error';
        }

        die(json_encode($result));
    }

    public function navigator_request() {
        $widget_id = $_REQUEST['widget'];
        $parts = explode('-', $widget_id, 2);

        $widget = 'widget_'.$parts[0];
        $id = intval($parts[1]);

        $widget = get_option($widget);
        $instance = isset($widget[$id]) ? $widget[$id] : null;

        if (is_null($instance)) {
            die('<li>'.__("Widget not found.", "gd-clever-widgets").'</li>');
        } else {
            global $wp_widget_factory;

            $obj_name = $this->widgets[$parts[0]];

            $widget_obj = $wp_widget_factory->widgets[$obj_name];
            $widget_obj->id = $widget_id;
            $widget_obj->number = $id;

            $instance = wp_parse_args($instance, $widget_obj->get_defaults());

            $args = array(
                'level' => intval($_REQUEST['level']), 
                'value' => trim($_REQUEST['value']), 
                'offset' => intval($_REQUEST['offset']),
                'current' => $_REQUEST['current'],
                'current_url' => $_REQUEST['current_url']
            );

            $widget_obj->init();

            die($widget_obj->draw_level($instance, $args));
        }
    }
}

global $_gdclw_core_ajax;
$_gdclw_core_ajax = new gdclw_ajax_core();

function gdclw_ajax() {
    global $_gdclw_core_ajax;
    return $_gdclw_core_ajax;
}
