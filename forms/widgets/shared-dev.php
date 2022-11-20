<h4><?php _e("Dummy Data", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('dummy_data'); ?>"><?php _e("Use Dummy Data", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->select_yesno(), array('id' => $this->get_field_id('dummy_data'), 'class' => 'widefat', 'name' => $this->get_field_name('dummy_data'), 'selected' => $instance['dummy_data'])); ?>
            </td>
            <td class="cell-right">
                <label><?php _e("About Dummy Data Mode:", "gd-clever-widgets"); ?></label>
                <em><?php _e("When Dummy Data is active, this widget will display random generated data, not actual website data.", "gd-clever-widgets"); ?></em>
            </td>
        </tr>
    </tbody>
</table>
