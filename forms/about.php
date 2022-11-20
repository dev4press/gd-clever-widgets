<?php

if (!defined('ABSPATH')) exit;

$_task = gdclw_admin()->task === false ? 'whatsnew' : gdclw_admin()->task;

if (!in_array($_task, array('changelog', 'whatsnew', 'info', 'dev4press'))) {
    $_task = 'whatsnew';
}

include(GDCLW_PATH.'forms/about/header.php');

include(GDCLW_PATH.'forms/about/'.$_task.'.php');

include(GDCLW_PATH.'forms/about/footer.php');
