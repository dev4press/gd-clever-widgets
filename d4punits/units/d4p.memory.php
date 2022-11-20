<?php

/*
Name:    d4punits: Memory
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Memory')) {
    class d4pLib_Unit_Memory extends d4pLib_UnitType {
        public $base = 'B';

        public function init() {
            $this->name = __("Memory", "d4punits");

            $this->list = array(
                'bit' => __("Bit", "d4punits"),
                'B' => __("Byte", "d4punits"),
                'KB' => __("Kilobyte", "d4punits"),
                'MB' => __("Megabyte", "d4punits"),
                'GB' => __("Gigabyte", "d4punits"),
                'TB' => __("Terabyte", "d4punits"),
                'PB' => __("Petabyte", "d4punits"),
                'CD74' => __("1 CD 74min", "d4punits"),
                'CD80' => __("1 CD 80min", "d4punits"),
                'DVD' => __("1 DVD", "d4punits"),
                'DVDDL' => __("1 DVD Dual Layer", "d4punits"),
                'BD' => __("1 BD", "d4punits"),
                'BDDL' => __("1 BD Dual Layer", "d4punits")
            );

            $this->convert = array(
                'bit' => 0.125,
                'B' => 1,
                'KB' => 1024,
                'MB' => 1048576,
                'GB' => 1073741824,
                'TB' => 1099511627800,
                'PB' => 1125899906800000,
                'CD74' => 681058304,
                'CD80' => 736279247,
                'DVD' => 5046586572.8,
                'DVDDL' => 9126805504,
                'BD' => 26843545600,
                'BDDL' => 53687091200
            );
        }
    }
}
