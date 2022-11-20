<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_core_settings extends d4p_plugin_settings_corex {
    public $base = 'gdclw';

    public $settings = array(
        'core' => array(
            'activated' => 0
        ),
        'settings' => array(

        ),
        'widgets' => array(
            'enhanced-text' => true,
            'enhanced-posts' => true,
            'enhanced-calendar' => true,
            'enhanced-cloud' => true,
            'enhanced-meta' => true,
            'currency-exchange' => true,
            'featured-post' => true,
            'related-posts' => true,
            'posts-authors' => true,
            'author-information' => true,
            'units-converter' => true,
            'navigator-date' => true,
            'navigator-menu' => true,
            'navigator-pages' => true,
            'navigator-terms' => true,
            'videos-playlist' => true,
            'qr-code' => true,
            'disable_wp_calendar' => false,
            'disable_wp_posts' => false,
            'disable_wp_cloud' => false,
            'disable_wp_meta' => false,
            'disable_wp_text' => false
        ),
        'navigator' => array(
            'dummy_data_mode' => false,
            'ajax_website_active' => false
        ),
        'converter' => array(
            'currency_google_timeout' => 24,
            'currency_ecb_timeout' => 24,
            'currency_oer_timeout' => 24,
            'currency_oer_app_id' => '',
            'currency_oer_https' => false
        )
    );

    protected function constructor() {
        $this->info = new gdclw_core_info();

        add_action('gdclw_load_settings', array($this, 'init'));
    }

    protected function _name($name) {
        return 'dev4press_'.$this->info->code.'_'.$name;
    }

    public function export_to_json($list = array()) {
        if (empty($list)) {
            $list = $this->_groups();
        }

        $data = new stdClass();
        $data->info = $this->current['info'];

        foreach ($list as $name) {
            $data->$name = $this->current[$name];
        }

        return json_encode($data);
    }

    public function clear_widgets_cache() {
        global $wpdb;

        $key_base = 'd4pclw%';

        $sql = sprintf("delete from %s where option_name like '_transient_%s' or option_name like '_transient_timeout_%s'", $wpdb->options, $key_base, $key_base);
        $wpdb->query($sql);
    }
}
