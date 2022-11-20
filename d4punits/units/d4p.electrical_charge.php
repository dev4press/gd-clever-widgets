<?php

/*
Name:    d4punits: Electrical Charge
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_ElectricalCharge')) {
    class d4pLib_Unit_ElectricalCharge extends d4pLib_UnitType {
        public $base = 'C';

        public function init() {
            $this->name = __("Electrical Charge", "d4punits");

            $this->list = array(
                'C' => __("Coulomb", "d4punits"),
                'nC' => __("Nanocoulomb", "d4punits"),
                'uC' => __("Microcoulomb", "d4punits"),
                'mC' => __("Millicoulomb", "d4punits"),
                'kC' => __("Kilocoulomb", "d4punits"),
                'MC' => __("Megacoulomb", "d4punits"),
                'GC' => __("Gigacoulomb", "d4punits"),
                'abC' => __("Abcoulomb", "d4punits"),
                'emu' => __("Electromagnetic unit of charge", "d4punits"),
                'ecu' => __("Electrostatic unit of chargee", "d4punits"),
                'F' => __("Faraday", "d4punits"),
                'Fr' => __("Franklin", "d4punits"),
                'Ah' => __("Ampere Hour", "d4punits"),
                'Am' => __("Ampere Minute", "d4punits"),
                'As' => __("Ampere Second", "d4punits"),
                'mAh' => __("Milliampere Hour", "d4punits"),
                'mAm' => __("Milliampere Minute", "d4punits"),
                'mAs' => __("Milliampere Second", "d4punits")
            );

            $this->convert = array(
                'C' => 1,
                'nC' => 0.000000001,
                'uC' => 0.000001,
                'mC' => 0.001,
                'kC' => 1000,
                'MC' => 1000000,
                'GC' => 1000000000,
                'abC' => 10,
                'emu' => 10,
                'ecu' => 0.000000000334,
                'F' => 96485.338300000003,
                'Fr' => 0.000000000334,
                'Ah' => 3600,
                'Am' => 60,
                'As' => 1,
                'mAh' => 3.6,
                'mAm' => 0.06,
                'mAs' => 0.001
            );
        }
    }
}
