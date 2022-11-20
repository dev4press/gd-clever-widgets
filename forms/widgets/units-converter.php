<?php

$list_units = d4p_units()->get_unit_types();

if (empty($instance['units'])) {
    $instance['units'] = array_keys($list_units);
}

?>
<h4><?php _e("Content", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('units'); ?>"><?php _e("Unit Types to Display", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_units, array('multi' => true, 'id' => $this->get_field_id('units'), 'class' => 'widefat', 'name' => $this->get_field_name('units'), 'selected' => $instance['units'])); ?>
            </td>
            <td class="cell-right">
                <label><?php _e("Information", "gd-clever-widgets"); ?>:</label>
                <p>
                    <?php _e("Select one or more unit types to display in the widget. If only one type is selected, rendered widget output will have selection box hidden.", "gd-clever-widgets"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('string_to'); ?>"><?php _e("String - To", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('string_to'); ?>" name="<?php echo $this->get_field_name('string_to'); ?>" type="text" value="<?php echo esc_attr($instance['string_to']); ?>" />
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('string_replace'); ?>"><?php _e("String - Replace", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('string_replace'); ?>" name="<?php echo $this->get_field_name('string_replace'); ?>" type="text" value="<?php echo esc_attr($instance['string_replace']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Style", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('_style'); ?>"><?php _e("Style", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->styles->converter, array('id' => $this->get_field_id('_style'), 'class' => 'widefat', 'name' => $this->get_field_name('_style'), 'selected' => $instance['_style'])); ?>
            </td>
            <td class="cell-right">&nbsp;</td>
        </tr>
    </tbody>
</table>
