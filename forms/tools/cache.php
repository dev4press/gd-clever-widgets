<div class="d4p-group d4p-group-reset d4p-group-important">
    <h3><?php _e("Important", "gd-clever-widgets"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("This tool can remove all cached data for widgets. This tool is useful for testing purposes if the data used by widget changes, without the need to wait for widget cache to expire on it's own.", "gd-clever-widgets"); ?><br/><br/>
        <?php _e("Deletion operations are not reversible, but next time widget that uses cache is displayed, it will rebuild cache.", "gd-clever-widgets"); ?> 
        <?php _e("If you don't use cache features for the widget, this tool will have no effect.", "gd-clever-widgets"); ?>
    </div>
</div>
<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Confirm that you want to clear cache", "gd-clever-widgets"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdclwtools[cache][widgets]" value="on" /> <?php _e("Clear Widgets Cache", "gd-clever-widgets"); ?>
        </label>
    </div>
</div>