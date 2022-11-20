<?php

if (!defined('ABSPATH')) exit;

$panels = array(
    'index' => array(
        'title' => __("Settings Index", "gd-clever-widgets"), 'icon' => 'cogs', 
        'info' => __("All plugin settings are split into several panels, and you access each starting from the right.", "gd-clever-widgets")),
    'widgets' => array(
        'title' => __("Plugin Widgets", "gd-clever-widgets"), 'icon' => 'dashboard',
        'break' => __("Basic", "gd-clever-widgets"),
        'info' => __("With these settings you can enable or disable individual plugin widgets.", "gd-clever-widgets")),
    'wp' => array(
        'title' => __("WordPress Widgets", "gd-clever-widgets"), 'icon' => 'wordpress', 
        'info' => __("With these settings you can disable selected default WordPress widgets.", "gd-clever-widgets")),
    'converter' => array(
        'title' => __("Conversion", "gd-clever-widgets"), 'icon' => 'refresh',
        'break' => __("Specific Widgets", "gd-clever-widgets"),
        'info' => __("These are settings for Conversion widget.", "gd-clever-widgets")),
    'navigator' => array(
        'title' => __("Navigation", "gd-clever-widgets"), 'icon' => 'chevron-circle-right', 
        'info' => __("These are settings for Navigation widgets.", "gd-clever-widgets"))
);

require_once(GDCLW_PATH.'forms/shared/top.php');

?>

<form method="post" action="">
    <?php settings_fields('gd-clever-widgets-settings'); ?>
    <input type="hidden" value="postback" name="gdclw_handler" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i aria-hidden="true" class="fa fa-cogs"></i>
                <h3><?php _e("Settings", "gd-clever-widgets"); ?></h3>
                <?php if ($_task != 'index') { ?>
                <h4><i aria-hidden="true" class="fa fa-<?php echo $panels[$_task]['icon']; ?>"></i> <?php echo $panels[$_task]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_task]['info']; ?>
            </div>
            <?php if ($_task != 'index') { ?>
                <div class="d4p-panel-buttons">
                    <input type="submit" value="<?php _e("Save Settings", "gd-clever-widgets"); ?>" class="button-primary">
                </div>
                <div class="d4p-return-to-top">
                    <a href="#wpwrap"><?php _e("Return to top", "gd-clever-widgets"); ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_task == 'index') {
            foreach ($panels as $panel => $obj) {
                if ($panel == 'index') continue;

                $url = 'options-general.php?page=gd-clever-widgets&panel=settings&task='.$panel;

                if (isset($obj['break'])) { ?>

                    <div style="clear: both"></div>
                    <div class="d4p-panel-break d4p-clearfix">
                        <h4><?php echo $obj['break']; ?></h4>
                    </div>
                    <div style="clear: both"></div>

                <?php } ?>

                <div class="d4p-options-panel">
                    <i aria-hidden="true" class="<?php echo d4p_get_icon_class($obj['icon']); ?>"></i>
                    <h5><?php echo $obj['title']; ?></h5>
                    <div>
                        <?php if (isset($obj['type'])) { ?>
                        <span><?php echo $obj['type']; ?></span>
                        <?php } ?>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Settings Panel", "gd-clever-widgets"); ?></a>
                    </div>
                </div>
        
                <?php
            }
        } else {
            require_once(GDCLW_D4PLIB.'admin/d4p.functions.php');
            require_once(GDCLW_D4PLIB.'admin/d4p.settings.php');

            include(GDCLW_PATH.'core/admin/options.php');

            $options = new gdclw_admin_settings();

            $panel = gdclw_admin()->task;
            $groups = $options->get($panel);

            $render = new d4pSettingsRender($panel, $groups);
            $render->base = 'gdclwvalue';
            $render->render();

            ?>

            <div class="clear"></div>
            <div style="padding-top: 15px; border-top: 1px solid #777; max-width: 800px;">
                <input type="submit" value="<?php _e("Save Settings", "gd-clever-widgets"); ?>" class="button-primary">
            </div>

            <?php

        }

        ?>
    </div>
</form>

<?php

require_once(GDCLW_PATH.'forms/shared/bottom.php');
