<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_admin_postback {
    public function __construct() {
        $page = isset($_POST['option_page']) ? $_POST['option_page'] : false;

        if ($page !== false) {
            if ($page == 'gd-clever-widgets-tools') {
                $this->tools();
            }

            if ($page == 'gd-clever-widgets-settings') {
                $this->settings();
            }

            do_action('gdclw_admin_postback_handler', $page);
        }
    }

    public function tools() {
        check_admin_referer('gd-clever-widgets-tools-options');

        if (gdclw_admin()->task == 'remove') {
            $this->remove();
        } else if (gdclw_admin()->task == 'cache') {
            $this->cache();
        } else if (gdclw_admin()->task == 'import') {
            $this->import();
        }
    }

    private function cache() {
        gdclw_settings()->clear_widgets_cache();

        wp_redirect(gdclw_admin()->current_url(true, false)."&message=cache-removed");
        exit;
    }

    private function import() {
        $message = '&message=import-failed';

        if (is_uploaded_file($_FILES['import_file']['tmp_name'])) {
            $raw = file_get_contents($_FILES['import_file']['tmp_name']);
            $data = json_decode($raw);

            if (is_object($data)) {
                gdclw_settings()->import_from_object($data);

                $message = '&message=imported';
            }
        }

        wp_redirect(gdclw_admin()->current_url(true, false).$message);
        exit;
    }

    private function remove() {
        $data = $_POST['gdclwtools'];

        $remove = isset($data['remove']) ? (array)$data['remove'] : array();

        if (empty($remove)) {
            $message = '&message=nothing';
        } else {
            if (isset($remove['settings']) && $remove['settings'] == 'on') {
                gdclw_settings()->remove_plugin_settings_by_group('info');
                gdclw_settings()->remove_plugin_settings_by_group('core');
                gdclw_settings()->remove_plugin_settings_by_group('widgets');
                gdclw_settings()->remove_plugin_settings_by_group('settings');
                gdclw_settings()->remove_plugin_settings_by_group('navigator');
                gdclw_settings()->remove_plugin_settings_by_group('converter');

                $message = '&message=settings-removed';
            }

            if (isset($remove['disable']) && $remove['disable'] == 'on') {
                deactivate_plugins('gd-clever-widgets/gd-clever-widgets.php', false, false);

                wp_redirect(admin_url('plugins.php'));
                exit;
            }
        }

        wp_redirect(gdclw_admin()->current_url().$message);
        exit;
    }

    private function save_settings($panel) {
        d4p_includes(array(
            array('name' => 'settings', 'directory' => 'admin'),
            array('name' => 'walkers', 'directory' => 'admin'),
            array('name' => 'functions', 'directory' => 'admin')
        ), GDCLW_D4PLIB);

        include(GDCLW_PATH.'core/admin/options.php');

        $options = new gdclw_admin_settings();
        $settings = $options->settings($panel);

        $processor = new d4pSettingsProcess($settings);
        $processor->base = 'gdclwvalue';

        $data = $processor->process();

        foreach ($data as $group => $values) {
            if (!empty($group)) {
                foreach ($values as $name => $value) {
                    $value = apply_filters('gdclw_save_settings_value', $value, $name, $group);

                    gdclw_settings()->set($name, $value, $group);
                }

                gdclw_settings()->save($group);
            }
        }

        do_action('gdclw_save_settings_'.$panel);
        do_action('gdclw_saved_the_settings');
    }

    private function settings() {
        check_admin_referer('gd-clever-widgets-settings-options');

        $this->save_settings(gdclw_admin()->task);

        wp_redirect(gdclw_admin()->current_url().'&message=saved');
        exit;
    }
}
