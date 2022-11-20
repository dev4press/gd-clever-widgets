<?php

/*
Name:    d4punits: Angle
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Angle')) {
    class d4pLib_Unit_Angle extends d4pLib_UnitType {
        public $base = 'radian';

        public function init() {
            $this->name = __("Angle", "d4punits");

            $this->list = array(
                'radian' => __("Radian", "d4punits"),
                'grad' => __("Grad", "d4punits"),
                'degree' => __("Degree", "d4punits"),
                'minute' => __("Minute", "d4punits"),
                'second' => __("Second", "d4punits"),
                'revolution' => __("Revolution", "d4punits"),
            );

            $this->convert = array(
                'radian' => 1,
                'grad' => 0.015707963268,
                'degree' => 0.01745329252,
                'minute' => 0.00029088820867,
                'second' => 0.0000048481368111,
                'revolution' => 6.283185307,
            );
        }
    }
}
