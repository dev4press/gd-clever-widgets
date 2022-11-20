<h4><?php _e("Visibility", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
    <tr>
        <td class="cell-left">
            <label for="<?php echo $this->get_field_id('_display'); ?>"><?php _e("Display To", "gd-clever-widgets"); ?>:</label>
            <?php d4p_render_grouped_select($list, array('id' => $this->get_field_id('_display'), 'class' => 'widefat', 'name' => $this->get_field_name('_display'), 'selected' => $instance['_display'])); ?>
        </td>
        <td class="cell-right">
            <label for="<?php echo $this->get_field_id('_hook'); ?>"><?php _e("Visibility Hook", "gd-clever-widgets"); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('_hook'); ?>" name="<?php echo $this->get_field_name('_hook'); ?>" type="text" value="<?php echo esc_attr($instance['_hook']); ?>" />
        </td>
    </tr>
    </tbody>
</table>

<h4><?php _e("Before and After Content", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('before'); ?>"><?php _e("Before", "gd-clever-widgets"); ?>:</label>
                <textarea class="widefat half-height" id="<?php echo $this->get_field_id('before'); ?>" name="<?php echo $this->get_field_name('before'); ?>"><?php echo esc_textarea($instance['before']); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('after'); ?>"><?php _e("After", "gd-clever-widgets"); ?>:</label>
                <textarea class="widefat half-height" id="<?php echo $this->get_field_id('after'); ?>" name="<?php echo $this->get_field_name('after'); ?>"><?php echo esc_textarea($instance['after']); ?></textarea>
            </td>
        </tr>
    </tbody>
</table>
