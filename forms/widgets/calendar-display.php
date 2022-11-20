<?php

$list_weekdays = array(
    'initials' => __("Initials", "gd-clever-widgets"),
    'abbrev' => __("Abbreviation", "gd-clever-widgets")
);

$list_days_titles = array(
    'date' => __("Date", "gd-clever-widgets"),
    'date_counts' => __("Date and Posts count", "gd-clever-widgets"),
    'titles' => __("List of Posts titles", "gd-clever-widgets")
);

?>
<h4><?php _e("Display Control", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('weekdays'); ?>"><?php _e("Weekdays Titles", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_weekdays, array('id' => $this->get_field_id('weekdays'), 'class' => 'widefat', 'name' => $this->get_field_name('weekdays'), 'selected' => $instance['weekdays'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('days_titles'); ?>"><?php _e("Days Title Tag", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_days_titles, array('id' => $this->get_field_id('days_titles'), 'class' => 'widefat', 'name' => $this->get_field_name('days_titles'), 'selected' => $instance['days_titles'])); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Predefined Style", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('_style'); ?>"><?php _e("Style", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->styles->calendar, array('id' => $this->get_field_id('_style'), 'class' => 'widefat', 'name' => $this->get_field_name('_style'), 'selected' => $instance['_style'])); ?>
            </td>
            <td class="cell-right">
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Additional", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('table_id'); ?>"><?php _e("ID for TABLE tag", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('table_id'); ?>" name="<?php echo $this->get_field_name('table_id'); ?>" type="text" value="<?php echo esc_attr($instance['table_id']); ?>" />
                <em><?php _e("Must be unique on each page. Some themes use this ID to style the calendar.", "gd-clever-widgets"); ?></em>
            </td>
            <td class="cell-right">&nbsp;</td>
        </tr>
    </tbody>
</table>
