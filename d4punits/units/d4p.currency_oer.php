<?php

/*
Name:    d4punits: Currency (Open Exchange Rates)
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Currency_OER')) {
    class d4pLib_Unit_Currency_OER extends d4pLib_UnitType {
        public $base = 'USD';
        public $timeout = 86400;
        public $app_id = '';
        public $https = false;

        public function init() {
            $this->name = __("Currency (Open Exchange Rates)", "d4punits");

            $this->display = array(
                'USD' => '$',
                'CAD' => '$',
                'HKD' => '$',
                'AUD' => '$',
                'NZD' => '$',
                'CHF' => 'Fr',
                'SEK' => 'Kr',
                'EUR' => '&euro;',
                'GBP' => '&pound;',
                'KRW' => '&#8361;',
                'JPY' => '&yen;',
                'CNY' => '&yen;',
                'INR' => '&#8377;',
                'NGN' => '&#8358;',
                'ILS' => '&#8362;',
                'KRW' => '&#8361;',
                'THB' => '&#3647;',
                'VND' => '&#8363;'
            );

            $this->_init_currencies();
            $this->_init_rates();
        }

        private function _init_currencies() {
            $key = 'currency_list_oer';
            $list = get_site_transient($key);

            if ($list === false || is_null($list) || empty($list)) {
                $list = $this->_from_json_currencies();

                if (is_array($list) && !empty($list)) {
                    set_site_transient($key, $list, $this->timeout);
                }
            }

            if (is_array($list) && !empty($list)) {
                $this->list = $list;
            }
        }

        private function _init_rates() {
            $key = 'currency_rates_oer';
            $rates = get_site_transient($key);

            if ($rates === false || is_null($rates) || empty($rates)) {
                $rates = $this->_from_json_rates();

                if (is_array($rates) && !empty($rates)) {
                    set_site_transient($key, $rates, $this->timeout);
                }
            }

            if (is_array($rates) && !empty($rates)) {
                $this->convert = $rates;
            }
        }

        private function _protocol() {
            return $this->https ? 'https' : 'http';
        }

        private function _from_json_rates() {
            $raw = wp_remote_get($this->_protocol().'://openexchangerates.org/api/latest.json?app_id='.$this->app_id);
            $json = json_decode($raw['body']);

            $rates = array();
            if (!isset($json->error)) {
                $raw = (array)$json->rates;

                foreach ($raw as $key => $value) {
                    $rates[$key] = 1 / $value;
                }
            }

            return $rates;
        }

        private function _from_json_currencies() {
            $raw = wp_remote_get($this->_protocol().'://openexchangerates.org/api/currencies.json');
            $json = json_decode($raw['body']);

            $list = (array)$json;

            foreach ($list as $key => &$item) {
                $item.= ' ('.$key.')';
            }

            return $list;
        }
    }
}
