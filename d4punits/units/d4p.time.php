<?php

/*
Name:    d4punits: Time
Version: v2.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com
*/

if (!class_exists('d4pLib_Unit_Time')) {
    class d4pLib_Unit_Time extends d4pLib_UnitType {
        public $base = 'ns';

        public function init() {
            $this->name = __("Time", "d4punits");

            $this->list = array(
                'ns' => __("Nanosecond", "d4punits"),
                'us' => __("Microsecond", "d4punits"),
                'ms' => __("Millisecond", "d4punits"),
                's' => __("Second", "d4punits"),
                'min' => __("Minute", "d4punits"),
                'hour' => __("Hour", "d4punits"),
                'day' => __("Day", "d4punits"),
                'week' => __("Week", "d4punits"),
                'month' => __("Month", "d4punits"),
                'year' => __("Year", "d4punits"),
                'century' => __("Century", "d4punits"),
                'millennium' => __("Millennium", "d4punits")
            );

            $this->convert = array(
                'ns' => 1,
                'us' => 1000,
                'ms' => 1000000,
                's' => 1000000000,
                'min' => 60000000000,
                'hour' => 3600000000000,
                'day' => 86400000000000,
                'week' => 604800000000000,
                'month' => 2592000000000000,
                'year' => 31556926000000000,
                'century' => 3155692600000000000,
                'millennium' => 31556926000000000000
            );
        }
    }
}
