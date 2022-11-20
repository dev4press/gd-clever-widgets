<?php

/*
Name:    d4punits: Electric Current
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_ElectricCurrent')) {
    class d4pLib_Unit_ElectricCurrent extends d4pLib_UnitType {
        public $base = 'A';

        public function init() {
            $this->name = __("Electric Current", "d4punits");

            $this->list = array(
                'A' => __("Ampere", "d4punits"),
                'mA' => __("Milliampere", "d4punits"),
                'abamp' => __("Abamper", "d4punits"),
                'MA' => __("Megampere", "d4punits"),
                'esu/s' => __("Statampere", "d4punits")
            );

            $this->convert = array(
                'A' => 1,
                'mA' => 0.001,
                'abamp' => 10,
                'MA' => 0.000333564095198,
                'esu/s' => 3.33564095198152e-010
            );
        }
    }
}
