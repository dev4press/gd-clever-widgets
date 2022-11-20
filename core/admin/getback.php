<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_admin_getback {
    public function __construct() {
        if (gdclw_admin()->panel === 'tools') {
            if (isset($_GET['run']) && $_GET['run'] == 'export') {
                $this->tools_export();
            }
        }

        do_action('gdclw_admin_getback_handler', gdclw_admin()->page);
    }

    private function tools_export() {
        check_ajax_referer('dev4press-plugin-export');

        if (!d4p_is_current_user_admin()) {
            wp_die(__("Only administrators can use export features.", "gd-clever-widgets"));
        }

        $export_date = date('Y-m-d-H-m-s');

        header('Content-type: application/json');
        header('Content-Disposition: attachment; filename="gd_clever_widgets_settings_'.$export_date.'.json"');

        die(gdclw_settings()->export_to_json());
    }
}
