<?php

/*
Plugin Name:       GD Clever Widgets Pro
Plugin URI:        https://plugins.dev4press.com/gd-clever-widgets/
Description:       A collection of sidebars widgets for unit conversion, advanced navigation, QR Code, videos, posts and authors information, enhanced versions of default widgets and more.
Author:            Milan Petrovic
Author URI:        https://www.dev4press.com/
Text Domain:       gd-clever-widgets
Version:           3.2
Requires at least: 5.1
Tested up to:      5.8
Requires PHP:      7.0
License:           GPLv3 or later
License URI:       https://www.gnu.org/licenses/gpl-3.0.html

== Copyright ==
Copyright 2008 - 2021 Milan Petrovic (email: support@dev4press.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

$gdclw_dirname_basic = dirname(__FILE__).'/';
$gdclw_urlname_basic = plugins_url('/gd-clever-widgets/');

define('GDCLW_PATH', $gdclw_dirname_basic);
define('GDCLW_URL', $gdclw_urlname_basic);
define('GDCLW_D4PLIB', $gdclw_dirname_basic.'d4plib/');

global $_gdclw_plugin, $_gdclw_settings;

require_once(GDCLW_PATH.'d4plib/d4p.core.php');

d4p_includes(array(
    array('name' => 'plugin', 'directory' => 'plugin'),
    array('name' => 'settings', 'directory' => 'plugin'),
    array('name' => 'widget', 'directory' => 'plugin'),
    'functions', 
    'sanitize', 
    'access', 
    'wp'
), GDCLW_D4PLIB);

require_once(GDCLW_PATH.'core/objects/core.templates.php');
require_once(GDCLW_PATH.'core/objects/core.styles.php');

require_once(GDCLW_PATH.'core/functions.php');
require_once(GDCLW_PATH.'core/plugin.php');
require_once(GDCLW_PATH.'core/version.php');
require_once(GDCLW_PATH.'core/settings.php');

$_gdclw_plugin = new gdclw_core_plugin();
$_gdclw_settings = new gdclw_core_settings();

function gdclw_plugin() {
    global $_gdclw_plugin;
    return $_gdclw_plugin;
}

function gdclw_settings() {
    global $_gdclw_settings;
    return $_gdclw_settings;
}

if (D4P_ADMIN) {
    d4p_includes(array(
        array('name' => 'admin', 'directory' => 'plugin'),
        array('name' => 'functions', 'directory' => 'admin')
    ), GDCLW_D4PLIB);

    require_once(GDCLW_PATH.'core/admin/plugin.php');
}

if (D4P_AJAX) {
    require_once(GDCLW_PATH.'core/ajax.php');
}
