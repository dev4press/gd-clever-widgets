<?php

/*
Name:    d4punits: Sound
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Sound')) {
    class d4pLib_Unit_Sound extends d4pLib_UnitType {
        public $base = 'B';

        public function init() {
            $this->name = __("Sound", "d4punits");

            $this->list = array(
                'B' => __("Bel", "d4punits"),
                'dB' => __("Decibel", "d4punits"),
                'neper' => __("Neper", "d4punits")
            );

            $this->convert = array(
                'B' => 1,
                'dB' => 10,
                'neper' => 1.1512779
            );
        }
    }
}
