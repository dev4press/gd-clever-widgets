<?php

/*
Name:    d4punits: Fuel Consumption
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_FuelConsumption')) {
    class d4pLib_Unit_FuelConsumption extends d4pLib_UnitType {
        public $base = 'L/km';

        public function init() {
            $this->name = __("Fuel Consumption", "d4punits");

            $this->display = array(
                'km/gallon/uk' => 'km/gallon',
                'km/gallon/us' => 'km/gallon',
                'mile/gallon/uk' => 'mile/gallon',
                'mile/gallon/us' => 'mile/gallon',
                'gallon/km/uk' => 'gallon/km',
                'gallon/km/us' => 'gallon/km',
                'gallon/mile/uk' => 'gallon/mile',
                'gallon/mile/us' => 'gallon/mile',
            );

            $this->list = array(
                'L/km' => __("Liter/100 Kilometer", "d4punits"),
                'L/mile' => __("Liter/100 Mile", "d4punits"),
                'km/L' => __("Kilometer/Liter", "d4punits"),
                'mile/L' => __("Mile/Liter", "d4punits"),
                'km/gallon/uk' => __("Kilometer/Gallon - UK", "d4punits"),
                'km/gallon/us' => __("Kilometer/Gallon - US", "d4punits"),
                'mile/gallon/uk' => __("Mile/Gallon - UK", "d4punits"),
                'mile/gallon/us' => __("Mile/Gallon - US", "d4punits"),
                'gallon/km/uk' => __("Gallon/100 Kilometer - UK", "d4punits"),
                'gallon/km/us' => __("Gallon/100 Kilometer - US", "d4punits"),
                'gallon/mile/uk' => __("Gallon/100 Mile - UK", "d4punits"),
                'gallon/mile/us' => __("Gallon/100 Mile - US", "d4punits")
            );

            $this->convert = array(
                'L/km' => 1,
                'L/mile' => 0.621371192237334,
                'km/L' => 100,
                'mile/L' => 62.1371192237334,
                'km/gallon/uk' => 454.609,
                'km/gallon/us' => 378.5411784,
                'mile/gallon/uk' => 282.480936331822,
                'mile/gallon/us' => 235.214583333333,
                'gallon/km/uk' => 4.54609,
                'gallon/km/us' => 3.785411784,
                'gallon/mile/uk' => 2.82480936331822,
                'gallon/mile/us' => 2.35214583333333
            );

            $this->system = array(
                'metric' => array('L/km', 'km/L'),
                'imperial' => array('L/mile', 'mile/L', 'mile/gallon/uk', 'gallon/mile/uk'),
                'us' => array('L/mile', 'mile/L', 'mile/gallon/us', 'gallon/mile/us')
            );
        }
    }
}
