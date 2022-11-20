<?php

/*
Name:    d4punits: Volume
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Volume')) {
    class d4pLib_Unit_Volume extends d4pLib_UnitType {
        public $base = 'l';

        public function init() {
            $this->name = __("Volume", "d4punits");

            $this->display = array(
                'dm3' => 'dm&sup3;',
                'mm3' => 'mm&sup3;',
                'm3' => 'm&sup3;',
                'km3' => 'km&sup3;',
                'cup/us' => 'cup',
                'tablespoon/us' => 'tablespoon',
                'teaspoon/us' => 'teaspoon',
                'barrel/us/petroleum' => 'barrel',
                'gallon/us' => 'gallon',
                'quart/us' => 'quart',
                'pint/us' => 'pint',
                'barrel/us/dry' => 'barrel',
                'bushel/us' => 'bushel',
                'gallon/us/dry' => 'gallon',
                'quart/us/dry' => 'quart',
                'pint/us/dry' => 'pint',
                'bushel/uk' => 'bushel',
                'gallon/uk' => 'gallon',
                'quart/uk' => 'quart',
                'pint/uk' => 'pint',
            );
            
            $this->list = array(
                'l' => __("Liter", "d4punits"),
                'dl' => __("Deciliter", "d4punits"),
                'cl' => __("Centiliter", "d4punits"),
                'ml' => __("Milliliter", "d4punits"),
                'ul' => __("Microliter", "d4punits"),
                'decl' => __("Decaliter", "d4punits"),
                'hl' => __("Hectoliter", "d4punits"),
                'dm3' => __("Cubic Decimeter", "d4punits"),
                'cc' => __("Cubic Centimeter", "d4punits"),
                'mm3' => __("Cubic Millimeter", "d4punits"),
                'm3' => __("Cubic Meter", "d4punits"),
                'km3' => __("Cubic Kilometer", "d4punits"),
                'cup' => __("Cup", "d4punits"),
                'tablespoon' => __("Table spoon", "d4punits"),
                'teaspoon' => __("Teas spoon", "d4punits"),
                'cup/us' => __("Cup / US", "d4punits"),
                'tablespoon/us' => __("Table spoon / US", "d4punits"),
                'teaspoon/us' => __("Teas spoon / US", "d4punits"),
                'barrel/us/petroleum' => __("Barrel Petroleum / US", "d4punits"),
                'gallon/us' => __("Gallon / US", "d4punits"),
                'quart/us' => __("Quart / US", "d4punits"),
                'pint/us' => __("Pint / US", "d4punits"),
                'barrel/us/dry' => __("Barrel Dry / US", "d4punits"),
                'bushel/us' => __("Bushel / US", "d4punits"),
                'gallon/us/dry' => __("Gallon Dry / US", "d4punits"),
                'quart/us/dry' => __("Quart Dry / US", "d4punits"),
                'pint/us/dry' => __("Pint Dry / US", "d4punits"),
                'bushel/uk' => __("Bushel / UK", "d4punits"),
                'gallon/uk' => __("Gallon / UK", "d4punits"),
                'quart/uk' => __("Quart / UK", "d4punits"),
                'pint/uk' => __("Pint / UK", "d4punits"),
            );

            $this->convert = array(
                'l' => 1,
                'dl' => 10,
                'cl' => 100,
                'ml' => 1000,
                'ul' => 1000000,
                'decl' => 0.1,
                'hl' => 0.01,
                'dm3' => 1,
                'cc' => 1000,
                'mm3' => 1000000,
                'm3' => 0.001,
                'km3' => 0.000000000001,
                'cup' => 4.167,
                'tablespoon' => 66.67,
                'teaspoon' => 200,
                'cup/us' => 4.227,
                'tablespoon/us' => 67.63,
                'teaspoon/us' => 202.9,
                'barrel/us/petroleum' => 0.00629,
                'gallon/us' => 0.2642,
                'quart/us' => 1.057,
                'pint/us' => 2.113,
                'barrel/us/dry' => 0.008648,
                'bushel/us' => 0.02838,
                'gallon/us/dry' => 0.227,
                'quart/us/dry' => 0.9081,
                'pint/us/dry' => 1.816,
                'bushel/uk' => 0.0275,
                'gallon/uk' => 0.22,
                'quart/uk' => 0.8799,
                'pint/uk' => 1.76,
            );
        }
    }
}
