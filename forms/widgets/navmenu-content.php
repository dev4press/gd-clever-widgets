<?php

$nav_menus = wp_get_nav_menus( array('orderby' => 'name') );

$list_menus = array();
foreach ($nav_menus as $obj) {
    $list_menus[$obj->term_id] = $obj->name;
}

$list_menu_hierarchy = array(
    'full' => __("Full Hierarchy", "gd-clever-widgets"), 
    'custom' => __("Select Custom Item", "gd-clever-widgets"), 
    'detect' => __("Based on Current Page", "gd-clever-widgets")
);

?>
<h4><?php _e("Data to Display", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e("Available Menus", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_menus, array('id' => $this->get_field_id('nav_menu'), 'class' => 'widefat', 'name' => $this->get_field_name('nav_menu'), 'selected' => $instance['nav_menu'])); ?>
            </td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('root_content'); ?>"><?php _e("Display Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_menu_hierarchy, array('id' => $this->get_field_id('root_content'), 'class' => 'widefat d4plib-block-switch', 'name' => $this->get_field_name('root_content'), 'selected' => $instance['root_content']), array('data-block' => 'root_content')); ?>
            </td>
            <td class="cell-right">
                <div class="cellblock-root_content cellblockname-full"<?php if ($instance['root_content'] != 'full') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('root_content'); ?>"><?php _e("Root Items", "gd-clever-widgets"); ?>:</label>
                    <em><?php _e("Full menu hierarchy for selected menu will always be displayed.", "gd-clever-widgets"); ?></em>
                </div>

                <div class="cellblock-root_content cellblockname-custom"<?php if ($instance['root_content'] != 'custom') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('root_item'); ?>"><?php _e("Custom Root Items Parent", "gd-clever-widgets"); ?>:</label>
                    <?php gdclw_render_dropdown_menu(array('menu' => $instance['nav_menu'], 'selected_item' => $instance['root_item'], 'menu_id' => $this->get_field_id('root_item'), 'menu_name' => $this->get_field_name('root_item'))); ?>
                    <label for="<?php echo $this->get_field_id('root_custom_top'); ?>"><?php _e("Show parent on top", "gd-clever-widgets"); ?>:</label>
                    <?php d4p_render_select(gdclw_plugin()->select_yesno(), array('id' => $this->get_field_id('root_custom_top'), 'class' => 'widefat', 'name' => $this->get_field_name('root_custom_top'), 'selected' => $instance['root_custom_top'])); ?>
                </div>

                <div class="cellblock-root_content cellblockname-detect"<?php if ($instance['root_content'] != 'detect') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('root_item'); ?>"><?php _e("Detect Root Items Parent", "gd-clever-widgets"); ?>:</label>
                    <em><?php _e("If on the menu item, plugin can detect this item and show only its child items.", "gd-clever-widgets"); ?></em>

                    <label for="<?php echo $this->get_field_id('root_detect_top'); ?>"><?php _e("Show parent on top", "gd-clever-widgets"); ?>:</label>
                    <?php d4p_render_select(gdclw_plugin()->select_yesno(), array('id' => $this->get_field_id('root_detect_top'), 'class' => 'widefat', 'name' => $this->get_field_name('root_detect_top'), 'selected' => $instance['root_detect_top'])); ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Number of Items", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('level_first'); ?>"><?php _e("Items to show on first level", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('level_first'); ?>" name="<?php echo $this->get_field_name('level_first'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['level_first']); ?>" />
                <em><?php _e("Leave at 0 to show all available items.", "gd-clever-widgets"); ?></em>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('level_inner'); ?>"><?php _e("Items to show on inner levels", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('level_inner'); ?>" name="<?php echo $this->get_field_name('level_inner'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['level_inner']); ?>" />
                <em><?php _e("Leave at 0 to show all available items.", "gd-clever-widgets"); ?></em>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Misc Settings", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('show_description'); ?>"><?php _e("Show Description", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->select_yesno(), array('id' => $this->get_field_id('show_description'), 'class' => 'widefat', 'name' => $this->get_field_name('show_description'), 'selected' => $instance['show_description'])); ?>
            </td>
            <td class="cell-right">
                
            </td>
        </tr>
    </tbody>
</table>
