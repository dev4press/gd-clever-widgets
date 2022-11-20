<?php

if (!defined('ABSPATH')) exit;

$panels = array(
    'index' => array(
        'title' => __("Tools Index", "gd-clever-widgets"), 'icon' => 'wrench', 
        'info' => __("All plugin tools are split into several panels, and you access each starting from the right.", "gd-clever-widgets")),
    'export' => array(
        'title' => __("Export Settings", "gd-clever-widgets"), 'icon' => 'download',
        'break' => __("Import Export", "gd-clever-widgets"),
        'button' => 'button', 'button_text' => __("Export", "gd-clever-widgets"),
        'info' => __("Export all plugin settings into file.", "gd-clever-widgets")),
    'import' => array(
        'title' => __("Import Settings", "gd-clever-widgets"), 'icon' => 'upload', 
        'button' => 'submit', 'button_text' => __("Import", "gd-clever-widgets"),
        'info' => __("Import all plugin settings from export file.", "gd-clever-widgets")),
    'cache' => array(
        'title' => __("Clear Cache", "gd-clever-widgets"), 'icon' => 'database',
        'break' => __("Cleanup", "gd-clever-widgets"),
        'button' => 'submit', 'button_text' => __("Clear", "gd-clever-widgets"),
        'info' => __("Remove all cached widgets data.", "gd-clever-widgets")),
    'remove' => array(
        'title' => __("Remove Settings", "gd-clever-widgets"), 'icon' => 'refresh', 
        'button' => 'submit', 'button_text' => __("Remove", "gd-clever-widgets"),
        'info' => __("Remove selected plugin settings and information.", "gd-clever-widgets"))
);

require_once(GDCLW_PATH.'forms/shared/top.php');

?>

<form method="post" action="" enctype="multipart/form-data">
    <?php settings_fields('gd-clever-widgets-tools'); ?>

    <input type="hidden" value="<?php echo $_task; ?>" name="gdclwtools[panel]" />
    <input type="hidden" value="postback" name="gdclw_handler" />

    <div class="d4p-content-left">
        <div class="d4p-panel-title">
            <i aria-hidden="true" class="fa fa-wrench"></i>
            <h3><?php _e("Tools", "gd-clever-widgets"); ?></h3>
            <?php if ($_task != 'index') { ?>
            <h4><i aria-hidden="true" class="fa fa-<?php echo $panels[$_task]['icon']; ?>"></i> <?php echo $panels[$_task]['title']; ?></h4>
            <?php } ?>
        </div>
        <div class="d4p-panel-info">
            <?php echo $panels[$_task]['info']; ?>
        </div>
        <?php if ($_task != 'index') { ?>
            <div class="d4p-panel-buttons">
                <input id="gdclw-tool-<?php echo $_task; ?>" class="button-primary" type="<?php echo $panels[$_task]['button']; ?>" value="<?php echo $panels[$_task]['button_text']; ?>" />
            </div>
        <?php } ?>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_task == 'index') {
            foreach ($panels as $panel => $obj) {
                if ($panel == 'index') continue;

                $url = 'options-general.php?page=gd-clever-widgets&panel=tools&task='.$panel;

                if (isset($obj['break'])) { ?>

                    <div style="clear: both"></div>
                    <div class="d4p-panel-break d4p-clearfix">
                        <h4><?php echo $obj['break']; ?></h4>
                    </div>
                    <div style="clear: both"></div>

                <?php } ?>

                <div class="d4p-options-panel">
                    <i aria-hidden="true" class="fa fa-<?php echo $obj['icon']; ?>"></i>
                    <h5><?php echo $obj['title']; ?></h5>
                    <div>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Tools Panel", "gd-clever-widgets"); ?></a>
                    </div>
                </div>

                <?php
            }
        } else {
            include(GDCLW_PATH.'forms/tools/'.$_task.'.php');
        }

        ?>
    </div>
</form>

<?php 

require_once(GDCLW_PATH.'forms/shared/bottom.php');
