<?php

/*
Name:    d4punits: Torque
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Illumination')) {
    class d4pLib_Unit_Illumination extends d4pLib_UnitType {
        public $base = 'lx';

        public function init() {
            $this->name = __("Illumination", "d4punits");

            $this->display = array(
                'uNm' => '&micro;Nm',
                'lmm2' => 'lm/m&sup2;',
                'lmcm2' => 'lm/cm&sup2;',
                'lmft2' => 'lm/ft&sup2;'
            );

            $this->list = array(
                'lx' => __("Lux", "d4punits"),
                'ph' => __("Phot", "d4punits"),
                'nox' => __("Nox", "d4punits"),
                'flame' => __("Flame", "d4punits"),
                'lmm2' => __("Lumen on Square Meter", "d4punits"),
                'lmcm2' => __("Lumen on Square Centimeter", "d4punits"),
                'lmft2' => __("Lumen on Square Foot", "d4punits")
            );

            $this->convert = array(
                'lx' => 1,
                'ph' => 0.0001,
                'nox' => 1000,
                'flame' => 0.02322576,
                'lmm2' => 1,
                'lmcm2' => 0.0001,
                'lmft2' => 0.09290304
            );

            $this->system = array(
                'metric' => array('lx', 'lmm2', 'lmcm2'),
                'imperial' => array('lmft2'),
                'us' => array('lmft2')
            );
        }
    }
}
