<?php

/*
Name:    d4punits: Frequency
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Frequency')) {
    class d4pLib_Unit_Frequency extends d4pLib_UnitType {
        public $base = 'Hz';

        public function init() {
            $this->name = __("Frequency", "d4punits");

            $this->list = array(
                'Hz' => __("Hertz", "d4punits"),
                'kHz' => __("Kilohertz", "d4punits"),
                'MHz' => __("Megahertz", "d4punits"),
                'GHz' => __("Gigahertz", "d4punits"),
                'THz' => __("Terahertz", "d4punits"),
                'mHz' => __("Millihertz", "d4punits"),
                'rad/hr' => __("Radian / Hour", "d4punits"),
                'rad/min' => __("Radian / Minute", "d4punits"),
                'rad/s' => __("Radian / Second", "d4punits"),
                'deg/hr' => __("Degree / Hour", "d4punits"),
                'deg/min' => __("Degree / Minute", "d4punits"),
                'deg/s' => __("Degree / Second", "d4punits"),
                'cps' => __("Cycle / Second", "d4punits")
            );

            $this->convert = array(
                'Hz' => 1,
                'kHz' => 1000,
                'MHz' => 1000000,
                'GHz' => 1000000000,
                'THz' => 1000000000000,
                'mHz' => 0.001,
                'rad/hr' => 0.000044209706414415,
                'rad/min' => 0.002652582384865,
                'rad/s' => 0.159154943091895,
                'deg/hr' => 0.000000771604938272,
                'deg/min' => 0.000046296296296296,
                'deg/s' => 0.002777777777778,
                'cps' => 1,
            );
        }
    }
}
