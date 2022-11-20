<h4><?php _e("Posts Rendering", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e("Template", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->templates->posts, array('id' => $this->get_field_id('template'), 'class' => 'widefat', 'name' => $this->get_field_name('template'), 'selected' => $instance['template'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('_style'); ?>"><?php _e("Style", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->styles->posts, array('id' => $this->get_field_id('_style'), 'class' => 'widefat', 'name' => $this->get_field_name('_style'), 'selected' => $instance['_style'])); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Misc Settings", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e("Excerpt Length (Words)", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['excerpt_length']); ?>" />
            </td>
            <td class="cell-right">&nbsp;</td>
        </tr>
    </tbody>
</table>
