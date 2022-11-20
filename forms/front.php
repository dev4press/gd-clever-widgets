<?php

if (!defined('ABSPATH')) exit;

$_panel = gdclw_admin()->panel;
$_task = gdclw_admin()->task;

$pages = array(
    'settings' => array('title' => __("Settings", "gd-clever-widgets"), 'icon' => 'cogs'),
    'tools' => array('title' => __("Tools", "gd-clever-widgets"), 'icon' => 'wrench'),
    'about' => array('title' => __("About", "gd-clever-widgets"), 'icon' => 'info-circle')
);

$load = isset($pages[$_panel]) ? $_panel : 'settings';

require_once(GDCLW_PATH.'forms/'.$load.'.php');
