<?php

$select_yesno = array(
    'yes' => __("Yes", "gd-clever-widgets"),
    'no' => __("No", "gd-clever-widgets")
);

$select_ecLevel = array(
    'L' => __("Low (7%)", "gd-clever-widgets"),
    'M' => __("Medium (15%)", "gd-clever-widgets"),
    'Q' => __("Quartile (25%)", "gd-clever-widgets"),
    'H' => __("High (30%)", "gd-clever-widgets")
);

$select_render = array(
    'div' => __("DIV", "gd-clever-widgets"),
    'image' => __("Image", "gd-clever-widgets"),
    'canvas' => __("Canvas", "gd-clever-widgets")
);

?>
<h4><?php _e("Size and Display Method", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e("Size (in pixels)", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['size']); ?>" /><br/>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('render'); ?>"><?php _e("Render As", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($select_render, array('selected' => $instance['render'], 'class' => 'widefat', 'name' => $this->get_field_name('render'), 'id' => $this->get_field_id('render'))); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Colors", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('fill'); ?>"><?php _e("Fill Color", "gd-clever-widgets"); ?>:</label>
                <input class="widefat d4p-color-picker" id="<?php echo $this->get_field_id('fill'); ?>" name="<?php echo $this->get_field_name('fill'); ?>" type="text" value="<?php echo esc_attr($instance['fill']); ?>" /><br/>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('background'); ?>"><?php _e("Background Color", "gd-clever-widgets"); ?>:</label>
                <input class="widefat d4p-color-picker" id="<?php echo $this->get_field_id('background'); ?>" name="<?php echo $this->get_field_name('background'); ?>" type="text" value="<?php echo esc_attr($instance['background']); ?>" /><br/>
            </td>
        </tr>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('transparent'); ?>"><?php _e("Transparent", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($select_yesno, array('selected' => $instance['transparent'], 'class' => 'widefat', 'name' => $this->get_field_name('transparent'), 'id' => $this->get_field_id('transparent'))); ?>
            </td>
            <td class="cell-right">
                <label><?php _e("Important", "gd-clever-widgets"); ?>:</label>
                <?php _e("If transparent is active, Background color will not be used.", "gd-clever-widgets"); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Settings", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('ecLevel'); ?>"><?php _e("Error Correction", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($select_ecLevel, array('selected' => $instance['ecLevel'], 'class' => 'widefat', 'name' => $this->get_field_name('ecLevel'), 'id' => $this->get_field_id('ecLevel'))); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('minVersion'); ?>"><?php _e("Min. Range (1 - 10)", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('minVersion'); ?>" name="<?php echo $this->get_field_name('minVersion'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['minVersion']); ?>" /><br/>
            </td>
        </tr>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('quiet'); ?>"><?php _e("Quiet Zone (1 - 4)", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('quiet'); ?>" name="<?php echo $this->get_field_name('quiet'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['quiet']); ?>" /><br/>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('radius'); ?>"><?php _e("Dot Radius (0 - 50)", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('radius'); ?>" name="<?php echo $this->get_field_name('radius'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['radius']); ?>" /><br/>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Display Textual Content", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('textual'); ?>"><?php _e("Show under the QR Code", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($select_yesno, array('selected' => $instance['textual'], 'class' => 'widefat', 'name' => $this->get_field_name('textual'), 'id' => $this->get_field_id('textual'))); ?>
            </td>
            <td class="cell-right">
                <label><?php _e("Important", "gd-clever-widgets"); ?>:</label>
                <?php _e("With this, plugin will display encoded content as text.", "gd-clever-widgets"); ?>
            </td>
        </tr>
    </tbody>
</table>
