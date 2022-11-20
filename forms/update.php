<?php

if (!defined('ABSPATH')) { exit; }

$_classes = array('d4p-wrap', 'wpv-'.GDCLW_WPV, 'd4p-page-update');

?>
<div class="<?php echo join(' ', $_classes); ?>">
    <div class="d4p-header">
        <div class="d4p-plugin">
            GD Clever Widgets
        </div>
    </div>
    <div class="d4p-content">
        <div class="d4p-content-left">
            <div class="d4p-panel-title">
                <i aria-hidden="true" class="fa fa-magic"></i>
                <h3><?php _e("Update", "gd-clever-widgets"); ?></h3>
            </div>
            <div class="d4p-panel-info">
                <?php _e("Before you continue, make sure plugin was successfully updated.", "gd-clever-widgets"); ?>
            </div>
        </div>
        <div class="d4p-content-right">
            <div class="d4p-update-info">
                <h3 style="margin-top: 0;"><?php _e("All Done", "gd-clever-widgets"); ?></h3>
                <?php

                    gdclw_settings()->set('install', false, 'info');
                    gdclw_settings()->set('update', false, 'info', true);

                    _e("Update completed.", "gd-clever-widgets");

                ?>
                <br/><br/><a class="button-primary" href="<?php echo d4p_current_url(); ?>"><?php _e("Click here to continue.", "gd-clever-widgets"); ?></a>

                <h3 style="margin: 20px 0;"><?php _e("Important Notice", "gd-clever-widgets"); ?></h3>
                <?php _e("Before you can use the plugin, clear the website and browser cache to make sure that latest JS and CSS files are loaded.", "gd-clever-widgets"); ?>
            </div>
            <?php echo gdclw_plugin()->recommend('update'); ?>
        </div>
    </div>
</div>