<?php

/*
Name:    d4punits Library
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com/

== Copyright ==
Copyright 2008 - 2019 Milan Petrovic (email: support@dev4press.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('D4PUNITS_VERSION')) { 
    define('D4PUNITS_VERSION', '2.2');
    define('D4PUNITS_BUILD', '2400');
}

if (!class_exists('d4pLib_UnitType')) {
    abstract class d4pLib_UnitType {
        public $name = '';
        public $base = '';
        public $list = array();
        public $convert = array();
        public $system = array();
        public $display;

        public function __construct($args = array()) {
            foreach ($args as $key => $value) {
                $this->$key = $value;
            }

            $this->init();
        }

        public function convert($value, $from, $to) {
            $ratio_from = $this->convert[$from];
            $ratio_to = $this->convert[$to];

            $value_base = $value * $ratio_from;
            return $value_base / $ratio_to;
        }

        public function is_unit_available($unit) {
            return isset($this->list[$unit]);
        }

        abstract public function init();
    }
}

if (!class_exists('d4pLib_Units')) {
    class d4pLib_Units {
        public $data = array();
        public $units = array();
        public $args = array();

        public function __construct() {}

        private function init() {
            $this->units = array(
                'angle' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Angle', 'name' => __("Angle", "d4punits")), 
                'area' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Area', 'name' => __("Area", "d4punits")), 
                'brightness' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Brightness', 'name' => __("Brightness", "d4punits")), 
                'currency_ecb' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Currency_ECB', 'name' => __("Currency (European Central Bank)", "d4punits"), 'currency' => __("European Central Bank", "d4punits")),
                'currency_oer' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Currency_OER', 'name' => __("Currency (Open Exchange Rates)", "d4punits"), 'currency' => __("Open Exchange Rates", "d4punits")), 
                'electric_current' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_ElectricCurrent', 'name' => __("Electric Current", "d4punits")), 
                'electrical_charge' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_ElectricalCharge', 'name' => __("Electrical Charge", "d4punits")), 
                'energy' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Energy', 'name' => __("Energy", "d4punits")),
                'frequency' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Frequency', 'name' => __("Frequency", "d4punits")),
                'fuel_consumption' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_FuelConsumption', 'name' => __("Fuel Consumption", "d4punits")), 
                'illumination' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Illumination', 'name' => __("Illumination", "d4punits")), 
                'length' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Lenght', 'name' => __("Lenght or Distance", "d4punits")), 
                'memory' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Memory', 'name' => __("Memory", "d4punits")), 
                'power' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Power', 'name' => __("Power", "d4punits")), 
                'sound' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Sound', 'name' => __("Sound", "d4punits")), 
                'speed' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Speed', 'name' => __("Speed", "d4punits")),
                'temperature' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Temperature', 'name' => __("Temperature", "d4punits")),
                'time' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Time', 'name' => __("Time", "d4punits")), 
                'torque' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Torque', 'name' => __("Torque", "d4punits")), 
                'volume' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_Volume', 'name' => __("Volume", "d4punits")),
                'weight' => array('source' => '__internal__', 'class' => 'd4pLib_Unit_WeightMass', 'name' => __("Weight / Mass", "d4punits"))
            );
        }

        public static function instance() {
            static $instance = null;

            if (null === $instance) {
                $instance = new d4pLib_Units();
                $instance->init();
            }

            return $instance;
        }

        public function register($name, $title, $source, $class) {
            if (isset($this->units[$name])) {
                unset($this->data[$name]);
            }

            $this->units[$name] = array('source' => $source, 'class' => $class, 'name' => $title);
        }

        public function get_unit_types() {
            $data = array();

            foreach ($this->units as $unit => $obj) {
                $data[$unit] = $obj['name'];
            }

            return $data;
        }

        public function get_currency_types() {
            $data = array();

            foreach ($this->units as $unit => $obj) {
                if (substr($unit, 0, 8) == 'currency') {
                    $data[$unit] = $obj['currency'];
                }
            }

            return $data;
        }

        public function get_no_currency_types() {
            $data = array();

            foreach ($this->units as $unit => $obj) {
                if (substr($unit, 0, 8) != 'currency') {
                    $data[$unit] = $obj['name'];
                }
            }

            return $data;
        }

        public function get_unit_type_values($name) {
            $this->load_unit_type($name);

            return $this->data[$name]->list;
        }

        public function get_unit_type_display($name, $unit) {
            $this->load_unit_type($name);

            if (isset($this->data[$name]) && isset($this->data[$name]->display[$unit])) {
                return $this->data[$name]->display[$unit];
            } else {
                return $unit;
            }
        }

        public function is_unit_available($name, $unit) {
            $this->load_unit_type($name);

            if (!isset($this->data[$name])) {
                return null;
            }

            return $this->data[$name]->is_unit_available($unit);
        }

        public function convert($name, $value, $from, $to) {
            $this->load_unit_type($name);

            if (!isset($this->data[$name])) {
                return null;
            }

            return $this->data[$name]->convert($value, $from, $to);
        }

        public function convert_from_base($name, $value, $to) {
            $this->load_unit_type($name);

            if (!isset($this->data[$name])) {
                return null;
            }

            return $this->convert($name, $value, $this->data[$name]->base, $to);
        }

        public function convert_to_base($name, $value, $from) {
            $this->load_unit_type($name);

            if (!isset($this->data[$name])) {
                return null;
            }

            return $this->convert($name, $value, $from, $this->data[$name]->base);
        }

        public function load_all_unit_types() {
            foreach (array_keys($this->units) as $name) {
                $this->load_unit_type($name);
            }
        }

        public function load($name, $args = array()) {
            $this->load_unit_type($name, $args);
        }

        public function is_loaded($name) {
            return isset($this->data[$name]);
        }

        private function load_unit_type($name, $args = array()) {
            if (!isset($this->data[$name])) {
                $unit = $this->units[$name];
                $path = $unit['source'] == '__internal__' ? dirname(__FILE__).'/units/d4p.'.$name.'.php' : $unit['source'];

                if (file_exists($path)) {
                    include($path);

                    $obj = $unit['class'];
                    $this->data[$name] = new $obj($args);
                }
            }
        }
    }

    function d4p_units() {
        return d4pLib_Units::instance();
    }
}
