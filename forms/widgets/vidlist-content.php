<h4><?php _e("Videos", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('videos'); ?>"><?php _e("List of Videos", "gd-clever-widgets"); ?>:</label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('before'); ?>" name="<?php echo $this->get_field_name('videos'); ?>"><?php echo esc_textarea(join(D4P_EOL, $instance['videos'])); ?></textarea>

                <em>
                    <?php _e("Place one video URL on each line. Only videos that are support for WordPress oEmbed (YouTube, Vimeo...) can be used. On save, each video will be checked and unsupported URL's will be removed.", "gd-clever-widgets"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>
