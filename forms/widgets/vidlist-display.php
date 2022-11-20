<?php

$list_videos_count = array(
    'all' => __("All listed videos", "gd-clever-widgets"),
    'limit' => __("Specified number of videos", "gd-clever-widgets")
);

$list_video_order = array(
    'listed' => __("Order as Listed", "gd-clever-widgets"),
    'reversed' => __("Reversed Order", "gd-clever-widgets"),
    'random' => __("Random", "gd-clever-widgets")
);

?>
<h4><?php _e("Limit videos to show", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('show'); ?>"><?php _e("Videos to show", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_videos_count, array('id' => $this->get_field_id('show'), 'class' => 'widefat', 'name' => $this->get_field_name('show'), 'selected' => $instance['show'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e("Number of Videos", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['limit']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Video dimensions", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e("Width", "gd-clever-widgets"); ?> (px):</label>
                <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['width']); ?>" />
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e("Height", "gd-clever-widgets"); ?> (px):</label>
                <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['height']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Videos ordering", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e("Ordering Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_video_order, array('id' => $this->get_field_id('order'), 'class' => 'widefat', 'name' => $this->get_field_name('order'), 'selected' => $instance['order'])); ?>
            </td>
            <td class="cell-right">
            </td>
        </tr>
    </tbody>
</table>
