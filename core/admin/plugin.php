<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_admin_core extends d4p_admin_core {
    public $plugin = 'gd-clever-widgets';

    public function __construct() {
        $this->url = GDCLW_URL;

        add_action('gdclw_plugin_init', array($this, 'core'));

        add_filter('plugin_action_links', array($this, 'plugin_actions'), 10, 2);
        add_filter('plugin_row_meta', array($this, 'plugin_links'), 10, 2);
    }

    public function plugin_actions($links, $file) {
        if ($file == $this->plugin.'/'.$this->plugin.'.php') {
            $settings_link = '<a href="options-general.php?page=gd-clever-widgets">'.__("Settings", "gd-clever-widgets").'</a>';
            array_unshift($links, $settings_link);
        }

        return $links;
    }

    public function plugin_links($links, $file) {
        if ($file == $this->plugin.'/'.$this->plugin.'.php') {
            $links[] = '<a target="_blank" href="https://support.dev4press.com/kb/product/'.$this->plugin.'/">'.__("Knowledge Base", "gd-clever-widgets").'</a>';
            $links[] = '<a target="_blank" href="https://support.dev4press.com/forums/forum/plugins/'.$this->plugin.'/">'.__("Support Forum", "gd-clever-widgets").'</a>';
        }

        return $links;
    }

    public function current_url($with_panel = true, $with_task = true) {
        $page = 'options-general.php?page='.$this->plugin;

        if ($with_panel && $this->panel !== false && $this->panel != '') {
            $page.= '&panel='.$this->panel;
        }

        if ($with_task && isset($this->task) && $this->task !== false && $this->task != '') {
            $page.= '&task='.$this->task;
        }

        return self_admin_url($page);
    }

    public function title() {
        return __("GD Clever Widgets Pro", "gd-clever-widgets");
    }

    public function core() {
        parent::core();

        add_action('admin_menu', array($this, 'admin_menu'));

        if (gdclw_settings()->is_install()) {
            add_action('admin_notices', array($this, 'install_notice'));
        }

        if (gdclw_settings()->is_update()) {
            add_action('admin_notices', array($this, 'update_notice'));
        }
    }

    public function install_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            echo '<div class="updated"><p>';
            echo __("GD Clever Widgets is activated and it needs to finish installation.", "gd-clever-widgets");
            echo ' <a href="options-general.php?page=gd-clever-widgets">'.__("Click Here", "gd-clever-widgets").'</a>.';
            echo '</p></div>';
        }
    }

    public function update_notice() {
        if (current_user_can('install_plugins') && $this->page === false) {
            echo '<div class="updated"><p>';
            echo __("GD Clever Widgets is updated, and you need to review the update process.", "gd-clever-widgets");
            echo ' <a href="options-general.php?page=gd-clever-widgets">'.__("Click Here", "gd-clever-widgets").'</a>.';
            echo '</p></div>';
        }
    }

    public function admin_menu() {
        $this->page_ids[] = add_options_page($this->title(), __("GD Clever Widgets", "gd-clever-widgets"), 'activate_plugins', $this->plugin, array($this, 'plugin_interface'));

        $this->admin_load_hooks();
    }

    public function admin_load_hooks() {
        foreach ($this->page_ids as $id) {
            add_action('load-'.$id, array($this, 'load_admin_page'));
        }
    }

    public function current_screen($screen) {
        if ($screen->id == 'settings_page_gd-clever-widgets') {
            $this->page = true;
        }

        if ($this->page) {
            if (isset($_GET['panel']) && $_GET['panel'] != '') {
                $this->panel = d4p_sanitize_slug($_GET['panel']);
            } else {
                $this->panel = 'settings';
            }

            if (isset($_GET['task']) && $_GET['task'] != '') {
                $this->task = d4p_sanitize_slug($_GET['task']);
            }
        }

        if (isset($_POST['gdclw_handler']) && $_POST['gdclw_handler'] == 'postback') {
            require_once(GDCLW_PATH.'core/admin/postback.php');

            new gdclw_admin_postback();
        } else if (isset($_GET['gdclw_handler']) && $_GET['gdclw_handler'] == 'getback') {
            require_once(GDCLW_PATH.'core/admin/getback.php');

            new gdclw_admin_getback();
        }
    }

    public function load_admin_page() {
        $this->help_tab_sidebar();

        do_action('gdpos_load_admin_page_'.$this->page);

        if ($this->panel !== false && $this->panel != '') {
            do_action('gdpos_load_admin_page_'.$this->page.'_'.$this->panel);
        }

        $this->help_tab_getting_help();
    }

    public function enqueue_scripts($hook) {
        if ($this->page !== false) {
            d4p_admin_enqueue_defaults();

            wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

            wp_enqueue_style('d4plib-font', $this->file('css', 'font', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-shared', $this->file('css', 'shared', true), array(), D4P_VERSION);
            wp_enqueue_style('d4plib-admin', $this->file('css', 'admin', true), array('d4plib-shared'), D4P_VERSION);

            wp_enqueue_script('d4plib-shared', $this->file('js', 'shared', true), array('jquery', 'wp-color-picker'), D4P_VERSION, true);
            wp_enqueue_script('d4plib-admin', $this->file('js', 'admin', true), array('d4plib-shared'), D4P_VERSION, true);

            wp_localize_script('d4plib-shared', 'd4plib_admin_data', array(
                'string_media_image_title' => __("Select Image", "gd-clever-widgets"),
                'string_media_image_button' => __("Use Selected Image", "gd-clever-widgets"),
                'string_are_you_sure' => __("Are you sure you want to do this?", "gd-clever-widgets"),
                'string_image_not_selected' => __("Image not selected.", "gd-clever-widgets")
            ));

            if ($this->panel == 'about') {
                wp_enqueue_style('d4plib-grid', $this->file('css', 'grid', true), array(), D4P_VERSION.'.'.D4P_BUILD);
            }
        }

        if ($hook == 'widgets.php') {
            wp_enqueue_script('suggest');
            wp_enqueue_style('wp-color-picker');

            wp_enqueue_style('d4plib-widgets', $this->file('css', 'widgets', true), array(), D4P_VERSION);
            wp_enqueue_script('d4plib-widgets', $this->file('js', 'widgets', true), array('jquery', 'wp-color-picker'), D4P_VERSION, true);

            wp_enqueue_style('gdclw-interface', $this->file('css', 'interface'), array('d4plib-widgets'), gdclw_settings()->info_version);
            wp_enqueue_script('gdclw-interface', $this->file('js', 'interface'), array('suggest', 'd4plib-widgets'), gdclw_settings()->info_version, true);
        }
    }

    public function install_or_update() {
        $install = gdclw_settings()->is_install();
        $update = gdclw_settings()->is_update();

        if ($install) {
            include(GDCLW_PATH.'forms/install.php');
        } else if ($update) {
            include(GDCLW_PATH.'forms/update.php');
        }

        return $install || $update;
    }

    public function plugin_interface() {
        if (!$this->install_or_update()) {
            require_once(GDCLW_PATH.'forms/front.php');
        }
    }
}

global $_gdclw_core_admin;
$_gdclw_core_admin = new gdclw_admin_core();

function gdclw_admin() {
    global $_gdclw_core_admin;
    return $_gdclw_core_admin;
}
