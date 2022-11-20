<?php

if (!defined('ABSPATH')) exit;

$_classes = array(
    'd4p-wrap', 
    'wpv-'.GDCLW_WPV, 
    'd4p-page-about',
    'd4p-panel-'.$_task);

$_tabs = array(
    'back' => '<span title="'.__("Back to plugin settings", "gd-clever-widgets").'" class="dashicons dashicons-admin-settings" style="font-size: 24px; width: 24px; height: 24px"></span>',
    'whatsnew' => __("What&#8217;s New", "gd-clever-widgets"),
    'info' => __("Info", "gd-clever-widgets"),
    'changelog' => __("Changelog", "gd-clever-widgets"),
    'dev4press' => __("Dev4Press", "gd-clever-widgets")
);

?>

<div class="<?php echo join(' ', $_classes); ?>">
    <h1><?php printf(__("Welcome to GD Clever Widgets Pro&nbsp;%s", "gd-clever-widgets"), gdclw_settings()->info_version); ?></h1>
    <p class="d4p-about-text">
        Enhanced and powerful search for bbPress powered forums, with options to filter results by post author, forums, publication period, topic tags and few other things.
    </p>
    <div class="d4p-about-badge" style="background-color: #744D08;">
        <i class="d4p-icon d4p-plugin-icon-gd-clever-widgets"></i>
        <?php printf(__("Version %s", "gd-clever-widgets"), gdclw_settings()->info_version); ?>
    </div>

    <h2 class="nav-tab-wrapper wp-clearfix">
        <?php

        foreach ($_tabs as $_tab => $_label) {
            $url = $_tab == 'back' ? admin_url('options-general.php?page=gd-clever-widgets') : admin_url('options-general.php?page=gd-clever-widgets&panel=about&task='.$_tab);
            echo '<a href="'.$url.'" class="nav-tab'.($_tab == $_task ? ' nav-tab-active' : '').'">'.$_label.'</a>';
        }

        ?>
    </h2>

    <div class="d4p-about-inner">
