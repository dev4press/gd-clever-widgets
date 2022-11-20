<?php

$list_date_archives = array(
    'decennially-yearly-monthly-daily' => __("Decades / Years / Months / Days", "gd-clever-widgets"), 
    'decennially-yearly-monthly' => __("Decades / Years / Months", "gd-clever-widgets"), 
    'yearly-monthly-daily' => __("Years / Months / Days", "gd-clever-widgets"), 
    'yearly-monthly' => __("Years / Months", "gd-clever-widgets"), 
    'yearly-daily' => __("Years / Days", "gd-clever-widgets"), 
    'monthly-daily' => __("Months / Days", "gd-clever-widgets")
);

$list_archive_hierarchy = array(
    'full' => __("Full Hierarchy", "gd-clever-widgets"), 
    'detect' => __("Based on Current Date", "gd-clever-widgets")
);

$list_sort_order = array(
    'DESC' => __("Descending", "gd-clever-widgets"), 
    'ASC' => __("Ascending", "gd-clever-widgets")
);

$list_decade_links = array(
    'none' => __("No Links", "gd-clever-widgets"), 
    'first_year' => __("First year in decade", "gd-clever-widgets")
);

?>
<h4><?php _e("Data to Display", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('archives'); ?>"><?php _e("Available Archives", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_date_archives, array('id' => $this->get_field_id('archives'), 'class' => 'widefat', 'name' => $this->get_field_name('archives'), 'selected' => $instance['archives'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('post_counts'); ?>"><?php _e("Show Posts Count", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->select_yesno(), array('id' => $this->get_field_id('post_counts'), 'class' => 'widefat', 'name' => $this->get_field_name('post_counts'), 'selected' => $instance['post_counts'])); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Hierarchy Display", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('root_content'); ?>"><?php _e("Display Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_archive_hierarchy, array('id' => $this->get_field_id('root_content'), 'class' => 'widefat d4plib-block-switch', 'name' => $this->get_field_name('root_content'), 'selected' => $instance['root_content']), array('data-block' => 'root_content')); ?>
            </td>
            <td class="cell-right">
                <div class="cellblock-root_content cellblockname-full"<?php if ($instance['root_content'] != 'full') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('root_content'); ?>"><?php _e("Root Dates", "gd-clever-widgets"); ?>:</label>
                    <em><?php _e("Full dates hierarchy will always be displayed.", "gd-clever-widgets"); ?></em>
                </div>

                <div class="cellblock-root_content cellblockname-detect"<?php if ($instance['root_content'] != 'detect') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('root_item'); ?>"><?php _e("Detect Root Date Parent", "gd-clever-widgets"); ?>:</label>
                    <em><?php _e("If in the date archive, plugin can detect this date and show only its child date archives.", "gd-clever-widgets"); ?></em>

                    <label for="<?php echo $this->get_field_id('root_detect_top'); ?>"><?php _e("Show parent date on top", "gd-clever-widgets"); ?>:</label>
                    <?php d4p_render_select(gdclw_plugin()->select_yesno(), array('id' => $this->get_field_id('root_detect_top'), 'class' => 'widefat', 'name' => $this->get_field_name('root_detect_top'), 'selected' => $instance['root_detect_top'])); ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Number of Items", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('level_first'); ?>"><?php _e("Items to show on first level", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('level_first'); ?>" name="<?php echo $this->get_field_name('level_first'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['level_first']); ?>" />
                <em><?php _e("Leave at 0 to show all available items.", "gd-clever-widgets"); ?></em>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('level_inner'); ?>"><?php _e("Items to show on inner levels", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('level_inner'); ?>" name="<?php echo $this->get_field_name('level_inner'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['level_inner']); ?>" />
                <em><?php _e("Leave at 0 to show all available items.", "gd-clever-widgets"); ?></em>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Misc Settings", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('sort_order'); ?>"><?php _e("Sort Order", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_order, array('id' => $this->get_field_id('sort_order'), 'class' => 'widefat', 'name' => $this->get_field_name('sort_order'), 'selected' => $instance['sort_order'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('decade_links'); ?>"><?php _e("Decade URL's", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_decade_links, array('id' => $this->get_field_id('decade_links'), 'class' => 'widefat', 'name' => $this->get_field_name('decade_links'), 'selected' => $instance['decade_links'])); ?>
            </td>
        </tr>
    </tbody>
</table>
