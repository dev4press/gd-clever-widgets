<?php

/*
Name:    d4punits: Speed
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Speed')) {
    class d4pLib_Unit_Speed extends d4pLib_UnitType {
        public $base = 'kp/h';

        public function init() {
            $this->name = __("Speed", "d4punits");

            $this->list = array(
                'mp/s' => __("Meters per second", "d4punits"),
                'kp/h' => __("Kilometers per hour", "d4punits"),
                'mp/h' => __("Miles per hour", "d4punits"),
                'kn' => __("Knots", "d4punits")
            );

            $this->convert = array(
                'mp/s' => 3.6,
                'kp/h' => 1,
                'mp/h' => 1.609344,
                'kn' => 1.852
            );

            $this->system = array(
                'metric' => array('mp/s', 'kp/h'),
                'imperial' => array('mp/h'),
                'us' => array('mp/h')
            );
        }
    }
}
