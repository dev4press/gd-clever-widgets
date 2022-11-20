<?php

/*
Name:    d4punits: Energy
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com/libs/gdr2/
Info:    http://en.wikipedia.org/wiki/Unit_conversion
*/

if (!class_exists('d4pLib_Unit_Energy')) {
    class d4pLib_Unit_Energy extends d4pLib_UnitType {
        public $base = 'Wh';

        public function init() {
            $this->name = __("Energy", "d4punits");

            $this->list = array(
                'Wh' => __("Watt Hour", "d4punits"),
                'Ws' => __("Watt Second", "d4punits"),
                'mWh' => __("Milliwatt Hour", "d4punits"),
                'kWh' => __("Kilowatt Hour", "d4punits"),
                'MWh' => __("Kilowatt Hour", "d4punits"),
                'GWh' => __("Gigawatt Hour", "d4punits"),
                'cal' => __("Calorie", "d4punits"),
                'kcal' => __("Kilocalorie", "d4punits"),
                'J' => __("Joule", "d4punits"),
                'kJ' => __("Kilojoule", "d4punits"),
                'MJ' => __("Megajoule", "d4punits"),
                'GJ' => __("Gigajoule", "d4punits"),
                'uJ' => __("Microjoule", "d4punits"),
                'mJ' => __("Millijoule", "d4punits")
            );

            $this->convert = array(
                'Wh' => 1,
                'Ws' => 0.000277777777778,
                'mWh' => 0.001,
                'kWh' => 1000,
                'MWh' => 1000000,
                'GWh' => 1000000000,
                'cal' => 0.001163,
                'kcal' => 1.163,
                'J' => 0.000277777777778,
                'kJ' => 0.277777777777778,
                'MJ' => 277.777777777778,
                'GJ' => 277777.777777778,
                'uJ' => 0.000000000277777777778,
                'mJ' => 0.000000277777777778
            );
        }
    }
}
