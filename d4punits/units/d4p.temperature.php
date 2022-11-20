<?php

/*
Name:    d4punits: Temperature
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Temperature')) {
    class d4pLib_Unit_Temperature extends d4pLib_UnitType {
        public $base = 'C';

        public function init() {
            $this->name = __("Temperature", "d4punits");

            $this->list = array(
                'C' => __("Celsius", "d4punits"),
                'F' => __("Fahrenheit", "d4punits"),
                'K' => __("Kelvin", "d4punits"),
                'R' => __("Reaumur", "d4punits")
            );

            $this->convert = array(
                'C' => array('ratio' => 1, 'offset' => 0),
                'F' => array('ratio' => 1.8, 'offset' => 32),
                'K' => array('ratio' => 1, 'offset' => 273),
                'R' => array('ratio' => 0.8, 'offset' => 0)
            );

            $this->system = array(
                'metric' => array('C', 'K'),
                'imperial' => array('F'),
                'us' => array('F')
            );
        }

        public function convert($value, $from, $to) {
            $ratio_from = $this->convert[$from];
            $ratio_to = $this->convert[$to];

            $value_base = ($value - $ratio_from['offset']) / $ratio_from['ratio'];
            echo $value_base * $ratio_to['ratio'] + $ratio_to['offset'];
        }
    }
}
