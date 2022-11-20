<?php

/*
Name:    d4punits: Weight / Mass
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_WeightMass')) {
    class d4pLib_Unit_WeightMass extends d4pLib_UnitType {
        public $base = 'mg';

        public function init() {
            $this->name = __("Weight / Mass", "d4punits");

            $this->list = array(
                'mg' => __("Milligram", "d4punits"),
                'g' => __("Gram", "d4punits"),
                'kg' => __("Kilogram", "d4punits"),
                't' => __("Tonne", "d4punits"),
                'oz' => __("Ounce", "d4punits"),
                'lb' => __("Pound", "d4punits"),
                'st' => __("Stone", "d4punits"),
                'qtr' => __("Quarter", "d4punits"),
                'carat' => __("Carat", "d4punits")
            );

            $this->convert = array(
                'mg' => 1,
                'g' => 1000,
                'kg' => 1000000,
                't' => 1000000000,
                'oz' => 28349.5231,
                'lb' => 453592.37,
                'st' => 6350293.18,
                'qtr' => 12700586.36,
                'carat' => 205.196548333
            );

            $this->system = array(
                'metric' => array('mg', 'g', 'kg', 't'),
                'imperial' => array('oz', 'lb', 'carat', 'st', 'qtr'),
                'us' => array('oz', 'lb', 'carat', 'st', 'qtr')
            );
        }
    }
}
