<h4><?php _e("Elements to show", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('show_avatar'); ?>">
                        <input class="widefat" <?php echo $instance['show_avatar'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_avatar'); ?>" name="<?php echo $this->get_field_name('show_avatar'); ?>" />
                        <?php _e("Show author's avatar", "gd-clever-widgets"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_description'); ?>">
                        <input class="widefat" <?php echo $instance['show_description'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_description'); ?>" name="<?php echo $this->get_field_name('show_description'); ?>" />
                        <?php _e("Show author's information if available", "gd-clever-widgets"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_recent'); ?>">
                        <input class="widefat" <?php echo $instance['show_recent'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_recent'); ?>" name="<?php echo $this->get_field_name('show_recent'); ?>" />
                        <?php _e("Show author's recent posts for selected post types", "gd-clever-widgets"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Additional Options", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e("Avatar size", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('avatar_size'); ?>" name="<?php echo $this->get_field_name('avatar_size'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['avatar_size']); ?>" />
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('recent_posts'); ?>"><?php _e("Recent posts to include", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('recent_posts'); ?>" name="<?php echo $this->get_field_name('recent_posts'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['recent_posts']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Authors Rendering", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e("Template", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->templates->authors, array('id' => $this->get_field_id('template'), 'class' => 'widefat', 'name' => $this->get_field_name('template'), 'selected' => $instance['template'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('_style'); ?>"><?php _e("Style", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->styles->authors, array('id' => $this->get_field_id('_style'), 'class' => 'widefat', 'name' => $this->get_field_name('_style'), 'selected' => $instance['_style'])); ?>
            </td>
        </tr>
    </tbody>
</table>
