<h4><?php _e("Text / HTML / PHP", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('content'); ?>"><?php _e("Content", "gd-clever-widgets"); ?>:</label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo esc_textarea($instance['content']); ?></textarea>

                <em>
                    <?php _e("Content can contain plain text, HTML and even PHP. Make sure PHP includes proper open and close tags (<strong>&lt;?php</strong> and <strong>?&gt;</strong>).", "gd-clever-widgets"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>
