<?php

$list_content = array(
    'auto' => __("Auto", "gd-clever-widgets"),
    'current' => __("Current", "gd-clever-widgets"),
    'month' => __("Selected", "gd-clever-widgets")
);

$list_months = array(
    1 => __("January", "gd-clever-widgets"),
    2 => __("February", "gd-clever-widgets"),
    3 => __("March", "gd-clever-widgets"),
    4 => __("April", "gd-clever-widgets"),
    5 => __("May", "gd-clever-widgets"),
    6 => __("June", "gd-clever-widgets"),
    7 => __("July", "gd-clever-widgets"),
    8 => __("August", "gd-clever-widgets"),
    9 => __("September", "gd-clever-widgets"),
    10 => __("October", "gd-clever-widgets"),
    11 => __("November", "gd-clever-widgets"),
    12 => __("December", "gd-clever-widgets")
);

?>
<h4><?php _e("Post types to use", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label><?php _e("Selected Post Types", "gd-clever-widgets"); ?>:</label>
                <div class="d4plib-checkbox-list">
                <?php

                foreach (gdcls_list_post_types() as $cpt => $name) {
                    $checked = in_array($cpt, $instance['post_type']) ? ' checked="checked"' : '';
                    echo '<label><input'.$checked.' type="checkbox" name="'.$this->get_field_name('post_type').'[]" value="'.$cpt.'" />'.$name.'</label>';
                }

                ?>
                </div>
            </td>
            <td class="cell-right">
                <em>
                    <?php _e("WordPress date based archives by default work only with Posts. If you want other post types to be used to generate the Calendar, you also need to update the archives to handle other post types there.", "gd-clever-widgets"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Calendar Content", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('content'); ?>"><?php _e("Month and Year to display", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_content, array('id' => $this->get_field_id('content'), 'class' => 'widefat d4plib-block-switch', 'name' => $this->get_field_name('content'), 'selected' => $instance['content']), array('data-block' => 'content')); ?>
            </td>
            <td class="cell-right">
                <div class="cellblock-content cellblockname-auto"<?php if ($instance['content'] != 'auto') { echo ' style="display: none"'; } ?>>
                    <label><?php _e("Auto Generated", "gd-clever-widgets"); ?>:</label>
                    <em><?php _e("Month and Year displayed will depend on current query to load page. If query is not setting calendar, current Month and Year will be used.", "gd-clever-widgets"); ?></em>
                </div>
                <div class="cellblock-content cellblockname-current"<?php if ($instance['content'] != 'current') { echo ' style="display: none"'; } ?>>
                    <label><?php _e("Current Month", "gd-clever-widgets"); ?>:</label>
                    <em><?php _e("Current Month and Year will be used to display calendar.", "gd-clever-widgets"); ?></em>
                </div>
                <div class="cellblock-content cellblockname-month"<?php if ($instance['content'] != 'month') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('date_month'); ?>"><?php _e("Month", "gd-clever-widgets"); ?>:</label>
                    <?php d4p_render_select($list_months, array('id' => $this->get_field_id('date_month'), 'class' => 'widefat', 'name' => $this->get_field_name('date_month'), 'selected' => $instance['date_month'])); ?>
                    <br/>
                    <label for="<?php echo $this->get_field_id('date_year'); ?>"><?php _e("Year", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('date_year'); ?>" name="<?php echo $this->get_field_name('date_year'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['date_year']); ?>" />
                </div>
            </td>
        </tr>
    </tbody>
</table>
