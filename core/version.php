<?php

if (!defined('ABSPATH')) { exit; }

class gdclw_core_info {
    public $name = 'GD Clever Widgets';
    public $code = 'gd-clever-widgets';

    public $version = '3.2';
    public $build = 180;
    public $status = 'stable';
    public $updated = '2021.07.23';
    public $url = 'https://plugins.dev4press.com/gd-clever-widgets/';
    public $author_name = 'Milan Petrovic';
    public $author_url = 'https://www.dev4press.com/';
    public $released = '2014.11.18';

    public $php = '7.0';
    public $mysql = '5.1';
    public $wordpress = '5.1';

    public $install = false;
    public $update = false;
    public $previous = 0;

    function __construct() { }

    public function to_array() {
        return (array)$this;
    }
}
