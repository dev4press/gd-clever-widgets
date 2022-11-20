<?php

/*
Name:    d4punits: Lenght or Distance
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Lenght')) {
    class d4pLib_Unit_Lenght extends d4pLib_UnitType {
        public $base = 'mm';

        public function init() {
            $this->name = __("Lenght or Distance", "d4punits");

            $this->display = array(
                'um' => '&micro;m',
                'uin' => '&micro;in'
            );

            $this->list = array(
                'nm' => __("Picometre", "d4punits"),
                'nm' => __("Nanometre", "d4punits"),
                'um' => __("Micrometre", "d4punits"),
                'mm' => __("Millimeter", "d4punits"),
                'cm' => __("Centimeter", "d4punits"),
                'dm' => __("Decimeter", "d4punits"),
                'm' => __("Meter", "d4punits"),
                'km' => __("Kilometer", "d4punits"),
                'pt' => __("Point", "d4punits"),
                'uin' => __("Micro Inch", "d4punits"),
                'in' => __("Inch", "d4punits"),
                'ft' => __("Feet", "d4punits"),
                'yd' => __("Yard", "d4punits"),
                'mi' => __("Mile", "d4punits"),
                'nmi' => __("Nautical Mile", "d4punits")
            );

            $this->convert = array(
                'pm' => 0.000000001,
                'nm' => 0.000001,
                'um' => 0.001,
                'mm' => 1,
                'cm' => 10,
                'dm' => 100,
                'm' => 1000,
                'km' => 1000000,
                'pt' => .3527778,
                'uin' => .0000254,
                'in' => 25.4,
                'ft' => 304.8,
                'yd' => 914.4,
                'mi' => 1609344,
                'nmi' => 1852000
            );

            $this->system = array(
                'metric' => array('pm', 'nm', 'um', 'mm', 'cm', 'dm', 'm', 'km'),
                'imperial' => array('pt', 'uin', 'in', 'ft', 'yd', 'mi', 'nmi'),
                'us' => array('pt', 'uin', 'in', 'ft', 'yd', 'mi', 'nmi')
            );
        }
    }
}
