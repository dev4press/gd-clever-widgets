<?php

/*
Name:    d4punits: Brightness
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Brightness')) {
    class d4pLib_Unit_Brightness extends d4pLib_UnitType {
        public $base = 'sb';

        public function init() {
            $this->name = __("Brightness", "d4punits");

            $this->display = array(
                'cd/cm2' => 'cd/cm&sup2;',
                'cd/m2' => 'cd/m&sup2;',
                'cd/in2' => 'cd/in&sup2;',
                'cd/ft2' => 'cd/ft&sup2;'
            );

            $this->list = array(
                'sb' => __("Stilb", "d4punits"),
                'cd/cm2' => __("Candela / square centimeter", "d4punits"),
                'cd/m2' => __("Candela / square meter", "d4punits"),
                'cd/in2' => __("Candela / square inch", "d4punits"),
                'cd/ft2' => __("Candela / square foot", "d4punits"),
                'La' => __("Lambert", "d4punits"),
                'fL' => __("FootLambert", "d4punits"),
                'mL' => __("MeterLambert", "d4punits"),
                'mLa' => __("MilliLambert", "d4punits")
            );

            $this->convert = array(
                'sb' => 1,
                'cd/cm2' => 1,
                'cd/m2' => 0.0001,
                'cd/in2' => 0.15500031000062,
                'cd/ft2' => 0.001076391041671,
                'La' => 0.318309886183791,
                'fL' => 0.000342625909964,
                'mL' => 0.0001,
                'mLa' => 0.000318309886184
            );
        }
    }
}
