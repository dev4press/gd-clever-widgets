<h4><?php _e("Navigation", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('markup_plus'); ?>"><?php _e("Open Level", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('markup_plus'); ?>" name="<?php echo $this->get_field_name('markup_plus'); ?>" type="text" value="<?php echo esc_attr($instance['markup_plus']); ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('markup_minus'); ?>"><?php _e("Close Level", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('markup_minus'); ?>" name="<?php echo $this->get_field_name('markup_minus'); ?>" type="text" value="<?php echo esc_attr($instance['markup_minus']); ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('markup_up'); ?>"><?php _e("Level Up", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('markup_up'); ?>" name="<?php echo $this->get_field_name('markup_up'); ?>" type="text" value="<?php echo esc_attr($instance['markup_up']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Loading Messages", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('markup_more'); ?>"><?php _e("Show More Message", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('markup_more'); ?>" name="<?php echo $this->get_field_name('markup_more'); ?>" type="text" value="<?php echo esc_attr($instance['markup_more']); ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('markup_wait'); ?>"><?php _e("Please Wait Message", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('markup_wait'); ?>" name="<?php echo $this->get_field_name('markup_wait'); ?>" type="text" value="<?php echo esc_attr($instance['markup_wait']); ?>" />
            </td>
        </tr>
    </tbody>
</table>