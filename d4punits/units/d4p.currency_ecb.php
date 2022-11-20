<?php

/*
Name:    d4punits: Currency (European Central Bank)
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Currency_ECB')) {
    class d4pLib_Unit_Currency_ECB extends d4pLib_UnitType {
        public $base = 'EUR';
        public $timeout = 86400;

        public function init() {
            $this->name = __("Currency (European Central Bank)", "d4punits");

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
                'ILS' => '&#8362;',
                'THB' => '&#3647;'
            );

            $this->list = array(
                'EUR' => 'Euro (EUR)',
                'USD' => 'US dollar (USD)',
                'JPY' => 'Japanese yen (JPY)',
                'BGN' => 'Bulgarian lev (BGN)',
                'CZK' => 'Czech koruna (CZK)',
                'DKK' => 'Danish krone (DKK)',
                'GBP' => 'Pound sterling (GBP)',
                'HUF' => 'Hungarian forint (HUF)',
                'LTL' => 'Lithuanian litas (LTL)',
                'PLN' => 'Polish zloty (PLN)',
                'RON' => 'New Romanian leu 1 (RON)',
                'SEK' => 'Swedish krona (SEK)',
                'CHF' => 'Swiss franc (CHF)',
                'NOK' => 'Norwegian krone (NOK)',
                'HRK' => 'Croatian kuna (HRK)',
                'RUB' => 'Russian rouble (RUB)',
                'TRY' => 'Turkish lira (TRY)',
                'AUD' => 'Australian dollar (AUD)',
                'BRL' => 'Brasilian real (BRL)',
                'CAD' => 'Canadian dollar (CAD)',
                'CNY' => 'Chinese yuan renminbi (CNY)',
                'HKD' => 'Hong Kong dollar (HKD)',
                'IDR' => 'Indonesian rupiah (IDR)',
                'ILS' => 'Israeli shekel (ILS)',
                'INR' => 'Indian rupee (INR)',
                'KRW' => 'South Korean won (KRW)',
                'MXN' => 'Mexican peso (MXN)',
                'MYR' => 'Malaysian ringgit (MYR)',
                'NZD' => 'New Zealand dollar (NZD)',
                'PHP' => 'Philippine peso (PHP)',
                'SGD' => 'Singapore dollar (SGD)',
                'THB' => 'Thai baht (THB)',
                'ZAR' => 'South African rand (ZAR)'
            );

            $this->_init_rates();
        }

        private function _init_rates() {
            $key = 'currency_rates_ecb';
            $rates = get_site_transient($key);
            if ($rates === false || is_null($rates) || empty($rates)) {
                $rates = $this->_from_xml();

                if (is_array($rates) && !empty($rates)) {
                    set_site_transient($key, $rates, $this->timeout);
                }
            }

            if (is_array($rates) && !empty($rates)) {
                $this->convert = $rates;
            }
        }

        private function _from_xml() {
            $xml = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");

            $list = array('EUR' => 1);
            foreach ($xml->Cube->Cube->Cube as $rate) {
                $list[(string)$rate["currency"]] = 1 / floatval((string)$rate["rate"]);
            }

            return $list;
        }
    }
}
