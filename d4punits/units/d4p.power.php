<?php

/*
Name:    d4punits: Power
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Power')) {
    class d4pLib_Unit_Power extends d4pLib_UnitType {
        public $base = 'W';

        public function init() {
            $this->name = __("Power", "d4punits");

            $this->list = array(
                'W' => __("Watt", "d4punits"),
                'kW' => __("Kilowatt", "d4punits"),
                'MB' => __("Megawatt", "d4punits"),
                'GB' => __("Gigawatt", "d4punits"),
                'hp' => __("Horsepower", "d4punits"),
                'hp-m' => __("Horsepower metric", "d4punits"),
                'mhp' => __("Millihorsepower", "d4punits"),
                'cal/hr' => __("Calorie / hour", "d4punits"),
                'cal/min' => __("Calorie / minute", "d4punits"),
                'cal/sec' => __("Calorie / second", "d4punits"),
                'joule/hr' => __("Joule / hour", "d4punits"),
                'joule/min' => __("Joule / minute", "d4punits"),
                'joule/sec' => __("Joule / second", "d4punits")
            );

            $this->convert = array(
                'W' => 1,
                'kB' => 1000,
                'MB' => 1000000,
                'GB' => 1000000000,
                'hp' => 745.69987158227,
                'hp-m' => 735.49875,
                'mhp' => 0.74569987158227,
                'cal/hr' => 0.001163,
                'cal/min' => 0.06978,
                'cal/sec' => 4.1868,
                'joule/hr' => 0.000277777777778,
                'joule/min' => 0.016666666666667,
                'joule/sec' => 1,
            );
        }
    }
}
