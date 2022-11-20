<div class="d4p-group d4p-group-reset d4p-group-important">
    <h3><?php _e("Important", "gd-clever-widgets"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("This tool can remove plugin settings saved in the WordPress options table.", "gd-clever-widgets"); ?><br/><br/>
        <?php _e("Deletion operations are not reversible, and it is recommended to create database backup before proceeding with this tool.", "gd-clever-widgets"); ?> 
        <?php _e("If you choose to remove plugin settings, that will also reinitialize all plugin settings to default values.", "gd-clever-widgets"); ?>
    </div>
</div>
<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Choose what you want to delete", "gd-clever-widgets"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdclwtools[remove][settings]" value="on" /> <?php _e("All Plugin Settings", "gd-clever-widgets"); ?>
        </label>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Disable Plugin", "gd-clever-widgets"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdclwtools[remove][disable]" value="on" /> <?php _e("Disable plugin", "gd-clever-widgets"); ?>
        </label>
    </div>
</div>
