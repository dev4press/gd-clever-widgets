<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <h4><?php _e("Logged out", "gd-clever-widgets"); ?></h4>
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('auth_login'); ?>">
                        <input class="widefat" <?php echo $instance['auth_login'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('auth_login'); ?>" name="<?php echo $this->get_field_name('auth_login'); ?>" />
                        <?php _e("Show login link", "gd-clever-widgets"); ?></label>

                    <label for="<?php echo $this->get_field_id('auth_register'); ?>">
                        <input class="widefat" <?php echo $instance['auth_register'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('auth_register'); ?>" name="<?php echo $this->get_field_name('auth_register'); ?>" />
                        <?php _e("Show register link", "gd-clever-widgets"); ?></label>
                </div>
            </td>
            <td class="cell-right">
                <h4><?php _e("Logged In", "gd-clever-widgets"); ?></h4>
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('auth_logout'); ?>">
                        <input class="widefat" <?php echo $instance['auth_logout'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('auth_logout'); ?>" name="<?php echo $this->get_field_name('auth_logout'); ?>" />
                        <?php _e("Show logout link", "gd-clever-widgets"); ?></label>

                    <label for="<?php echo $this->get_field_id('auth_wpadmin'); ?>">
                        <input class="widefat" <?php echo $instance['auth_wpadmin'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('auth_wpadmin'); ?>" name="<?php echo $this->get_field_name('auth_wpadmin'); ?>" />
                        <?php _e("Show administration link", "gd-clever-widgets"); ?></label>

                    <label for="<?php echo $this->get_field_id('auth_profile'); ?>">
                        <input class="widefat" <?php echo $instance['auth_profile'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('auth_profile'); ?>" name="<?php echo $this->get_field_name('auth_profile'); ?>" />
                        <?php _e("Show profile link", "gd-clever-widgets"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Additional Links", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('rss_entries'); ?>">
                        <input class="widefat" <?php echo $instance['rss_entries'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('rss_entries'); ?>" name="<?php echo $this->get_field_name('rss_entries'); ?>" />
                        <?php _e("RSS Entries link", "gd-clever-widgets"); ?></label>

                    <label for="<?php echo $this->get_field_id('rss_comments'); ?>">
                        <input class="widefat" <?php echo $instance['rss_comments'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('rss_comments'); ?>" name="<?php echo $this->get_field_name('rss_comments'); ?>" />
                        <?php _e("RSS Comments link", "gd-clever-widgets"); ?></label>
                </div>
            </td>
            <td class="cell-right">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('link_wordpress'); ?>">
                        <input class="widefat" <?php echo $instance['link_wordpress'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('link_wordpress'); ?>" name="<?php echo $this->get_field_name('link_wordpress'); ?>" />
                        <?php _e("WordPress.org link", "gd-clever-widgets"); ?></label>

                    <label for="<?php echo $this->get_field_id('link_dev4press'); ?>">
                        <input class="widefat" <?php echo $instance['link_dev4press'] ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('link_dev4press'); ?>" name="<?php echo $this->get_field_name('link_dev4press'); ?>" />
                        <?php _e("Dev4Press.com link", "gd-clever-widgets"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>
