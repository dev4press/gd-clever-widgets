<h4><?php _e("Cache", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('_cached'); ?>"><?php _e("Cache time (in hours)", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('_cached'); ?>" name="<?php echo $this->get_field_name('_cached'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['_cached']); ?>" />
            </td>
            <td class="cell-right">
                <label><?php _e("Information", "gd-clever-widgets"); ?>:</label>
                <em class="solo-content"><?php

                _e("Widget output will be stored as transient record for the time period specified.", "gd-clever-widgets");

                ?></em>
            </td>
        </tr>
    </tbody>
</table>