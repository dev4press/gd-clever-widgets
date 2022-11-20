<?php

$select_yesno = array(
    'yes' => __("Yes", "gd-clever-widgets"),
    'no' => __("No", "gd-clever-widgets")
);

?>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <h4><?php _e("Term Size Range", "gd-clever-widgets"); ?></h4>

                <label for="<?php echo $this->get_field_id('smallest'); ?>"><?php _e("Smallest", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('smallest'); ?>" name="<?php echo $this->get_field_name('smallest'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['smallest']); ?>" /><br/>
                <label for="<?php echo $this->get_field_id('largest'); ?>"><?php _e("Largest", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('largest'); ?>" name="<?php echo $this->get_field_name('largest'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['largest']); ?>" /><br/>
                <label for="<?php echo $this->get_field_id('unit'); ?>"><?php _e("Size Unit", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(d4p_css_size_units(), array('id' => $this->get_field_id('unit'), 'class' => 'widefat', 'name' => $this->get_field_name('unit'), 'selected' => $instance['unit'])); ?>
            </td>
            <td class="cell-right">
                <h4><?php _e("Term Wrapping", "gd-clever-widgets"); ?></h4>

                <label for="<?php echo $this->get_field_id('separator'); ?>"><?php _e("Separator", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('separator'); ?>" name="<?php echo $this->get_field_name('separator'); ?>" type="text" value="<?php echo esc_attr($instance['separator']); ?>" /><br/>
                <label for="<?php echo $this->get_field_id('prefix'); ?>"><?php _e("Prefix", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('prefix'); ?>" name="<?php echo $this->get_field_name('prefix'); ?>" type="text" value="<?php echo esc_attr($instance['prefix']); ?>" /><br/>
                <label for="<?php echo $this->get_field_id('suffix'); ?>"><?php _e("Suffix", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('suffix'); ?>" name="<?php echo $this->get_field_name('suffix'); ?>" type="text" value="<?php echo esc_attr($instance['suffix']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Additional Options", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('show_counts'); ?>"><?php _e("Show Counts", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($select_yesno, array('id' => $this->get_field_id('show_counts'), 'class' => 'widefat', 'name' => $this->get_field_name('show_counts'), 'selected' => $instance['show_counts'])); ?>
            </td>
            <td class="cell-right">
            </td>
        </tr>
    </tbody>
</table>