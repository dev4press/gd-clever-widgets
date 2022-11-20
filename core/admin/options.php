<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_admin_settings {
    private $settings;

    function __construct() {
        $this->init();
    }

    public function get($panel, $group = '') {
        if ($group == '') {
            return $this->settings[$panel];
        } else {
            return $this->settings[$panel][$group];
        }
    }

    public function settings($panel) {
        $list = array();

        foreach ($this->settings[$panel] as $obj) {
            foreach ($obj['settings'] as $o) {
                $list[] = $o;
            }
        }

        return $list;
    }

    private function init() {
        $this->settings = array(
            'widgets' => array(
                'widgets_enhanced' => array('name' => __("Enhanced Widgets", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('widgets', 'enhanced-text', __("Text", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('enhanced-text', 'widgets')),
                    new d4pSettingElement('widgets', 'enhanced-posts', __("Posts", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('enhanced-posts', 'widgets')),
                    new d4pSettingElement('widgets', 'enhanced-meta', __("Meta", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('enhanced-meta', 'widgets')),
                    new d4pSettingElement('widgets', 'enhanced-calendar', __("Calendar", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('enhanced-calendar', 'widgets')),
                    new d4pSettingElement('widgets', 'enhanced-cloud', __("Terms Cloud", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('enhanced-cloud', 'widgets'))
                )),
                'widgets_navigator' => array('name' => __("Navigator Widgets", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('widgets', 'navigator-date', __("Date Archives", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('navigator-date', 'widgets')),
                    new d4pSettingElement('widgets', 'navigator-menu', __("Menu", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('navigator-menu', 'widgets')),
                    new d4pSettingElement('widgets', 'navigator-pages', __("Pages", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('navigator-pages', 'widgets')),
                    new d4pSettingElement('widgets', 'navigator-terms', __("Terms", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('navigator-terms', 'widgets'))
                )),
                'widgets_content' => array('name' => __("Content Widgets", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('widgets', 'author-information', __("Author Information", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('author-information', 'widgets')),
                    new d4pSettingElement('widgets', 'posts-authors', __("Posts Authors", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('posts-authors', 'widgets')),
                    new d4pSettingElement('widgets', 'featured-post', __("Featured Post", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('featured-post', 'widgets')),
                    new d4pSettingElement('widgets', 'related-posts', __("Related Posts", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('related-posts', 'widgets'))
                )),
                'widgets_convert' => array('name' => __("Conversion Widgets", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('widgets', 'units-converter', __("Units Conversion", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('units-converter', 'widgets')),
                    new d4pSettingElement('widgets', 'currency-exchange', __("Currency Exchange", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('currency-exchange', 'widgets'))
                )),
                'widgets_more' => array('name' => __("Other Widgets", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('widgets', 'qr-code', __("QR Code", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('qr-code', 'widgets')),
                    new d4pSettingElement('widgets', 'videos-playlist', __("Videos Playlist", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('videos-playlist', 'widgets'))
                ))
            ),
            'wp' => array(
                'widgets_wp' => array('name' => __("Disable some default WordPress Widgets", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('widgets', 'disable_wp_text', __("Calendar", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('disable_wp_text', 'widgets'), '', '', array('label' => __("Disabled", "gd-clever-widgets"))),
                    new d4pSettingElement('widgets', 'disable_wp_meta', __("Meta", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('disable_wp_meta', 'widgets'), '', '', array('label' => __("Disabled", "gd-clever-widgets"))),
                    new d4pSettingElement('widgets', 'disable_wp_posts', __("Recent Posts", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('disable_wp_posts', 'widgets'), '', '', array('label' => __("Disabled", "gd-clever-widgets"))),
                    new d4pSettingElement('widgets', 'disable_wp_cloud', __("Tag Cloud", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('disable_wp_cloud', 'widgets'), '', '', array('label' => __("Disabled", "gd-clever-widgets"))),
                    new d4pSettingElement('widgets', 'disable_wp_calendar', __("Text", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('disable_wp_calendar', 'widgets'), '', '', array('label' => __("Disabled", "gd-clever-widgets")))
                ))
            ),
            'navigator' => array(
                'navigator_website' => array('name' => __("Website Loading", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('navigator', 'ajax_website_active', __("Website uses AJAX Loading", "gd-clever-widgets"), '', d4pSettingType::BOOLEAN, gdclw_settings()->get('ajax_website_active', 'navigator')),
                )),
                'navigator_development' => array('name' => __("Development Mode", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('navigator', 'dummy_data_mode', __("Dummy Data Available", "gd-clever-widgets"), __("Widgets will get extra settings tab called DEV with option to use dummy data for development purposes.", "gd-clever-widgets"), d4pSettingType::BOOLEAN, gdclw_settings()->get('dummy_data_mode', 'navigator')),
                ))
            ),
            'converter' => array(
                'currency_google' => array('name' => __("Currency: Google", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('converter', 'currency_google_timeout', __("Cache Timeout", "gd-clever-widgets"), __("Google currency rates are updated once a day.", "gd-clever-widgets"), d4pSettingType::INTEGER, gdclw_settings()->get('currency_google_timeout', 'converter'))
                )),
                'currency_ecb' => array('name' => __("Currency: European Central Bank", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('converter', 'currency_ecb_timeout', __("Cache Timeout", "gd-clever-widgets"), __("European Central Bank currency rates are updated once a day.", "gd-clever-widgets"), d4pSettingType::INTEGER, gdclw_settings()->get('currency_ecb_timeout', 'converter'))
                )),
                'currency_oer' => array('name' => __("Currency: Open Exchange Rates", "gd-clever-widgets"), 'settings' => array(
                    new d4pSettingElement('converter', 'currency_oer_timeout', __("Cache Timeout", "gd-clever-widgets"), __("Open Exchange Rates currency rates are updated once every hour.", "gd-clever-widgets"), d4pSettingType::INTEGER, gdclw_settings()->get('currency_oer_timeout', 'converter')),
                    new d4pSettingElement('converter', 'currency_oer_app_id', __("App ID", "gd-clever-widgets"), __("This service requires App ID to work. Both Free and Pro accounts are supported. To get the App ID, you need to register for an account here:", "gd-clever-widgets").' <a target="_blank" href="https://openexchangerates.org/">openexchangerates.org</a>', d4pSettingType::TEXT, gdclw_settings()->get('currency_oer_app_id', 'converter')),
                    new d4pSettingElement('converter', 'currency_oer_https', __("Secure Connection", "gd-clever-widgets"), __("Secure connection requires Pro account for Open Exchange Rates service. Do not enable this if you are using Free account.", "gd-clever-widgets"), d4pSettingType::BOOLEAN, gdclw_settings()->get('currency_oer_https', 'converter'))
                ))
            )
        );
    }       
}
