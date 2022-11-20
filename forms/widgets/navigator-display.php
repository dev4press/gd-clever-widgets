<?php

$list_animate = array('__none__' => __("None", "gd-clever-widgets"),
                      'slideDown' => __("Slide Down", "gd-clever-widgets"),
                      'fadeIn' => __("Fade In", "gd-clever-widgets"));

$list_current = array('mark' => __("Yes", "gd-clever-widgets"), 
                      'hide' => __("No", "gd-clever-widgets"));

?>
<h4><?php _e("Animation", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('animate_method'); ?>"><?php _e("Animate Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_animate, array('id' => $this->get_field_id('animate_method'), 'class' => 'widefat', 'name' => $this->get_field_name('animate_method'), 'selected' => $instance['animate_method'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('animate_speed'); ?>"><?php _e("Animate Speed", "gd-clever-widgets"); ?> (ms):</label>
                <input class="widefat" id="<?php echo $this->get_field_id('animate_speed'); ?>" name="<?php echo $this->get_field_name('animate_speed'); ?>" type="number" min="0" step="10" value="<?php echo esc_attr($instance['animate_speed']); ?>" />
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Style", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('_style'); ?>"><?php _e("Style", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->styles->navigator, array('id' => $this->get_field_id('_style'), 'class' => 'widefat', 'name' => $this->get_field_name('_style'), 'selected' => $instance['_style'])); ?>
            </td>
            <td class="cell-right">&nbsp;</td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Additional", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('mark_current'); ?>"><?php _e("Mark Current Item", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_current, array('id' => $this->get_field_id('mark_current'), 'class' => 'widefat', 'name' => $this->get_field_name('mark_current'), 'selected' => $instance['mark_current'])); ?>
            </td>
            <td class="cell-right">&nbsp;</td>
        </tr>
    </tbody>
</table>
