<?php

$post_types = get_post_types(array('public' => true), 'objects');
$list_types = array(
    array('title' => __("Hierarchical", "gd-clever-widgets"), 'values' => array()),
    array('title' => __("Non-Hierarchical", "gd-clever-widgets"), 'values' => array())
);

foreach ($post_types as $cpt => $obj) {
    if ($obj->hierarchical) {
        $list_types[0]['values'][$cpt] = $obj->labels->name;
    } else {
        $list_types[1]['values'][$cpt] = $obj->labels->name;
    }
}

$list_page_hierarchy = array(
    'full' => __("Full Hierarchy", "gd-clever-widgets"), 
    'custom' => __("Select Custom Post", "gd-clever-widgets"), 
    'detect' => __("Based on Current Post", "gd-clever-widgets")
);

$list_sort_column = array(
    'none' => __("No Sorting", "gd-clever-widgets"), 
    'ID' => __("Post ID", "gd-clever-widgets"), 
    'title' => __("Post Title", "gd-clever-widgets"), 
    'name' => __("Post Slug", "gd-clever-widgets"), 
    'menu_order' => __("Menu Order", "gd-clever-widgets"), 
    'rand' => __("Random", "gd-clever-widgets"), 
    'comment_count' => __("Comments Count", "gd-clever-widgets"), 
    'author' => __("Post Author", "gd-clever-widgets"), 
    'date' => __("Post Published Date", "gd-clever-widgets"),
    'modified' => __("Post Modified Date", "gd-clever-widgets")
);

$list_sort_order = array(
    'DESC' => __("Descending", "gd-clever-widgets"), 
    'ASC' => __("Ascending", "gd-clever-widgets")
);

?>
<h4><?php _e("Data to Display", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e("Available Post Types", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_grouped_select($list_types, array('id' => $this->get_field_id('post_type'), 'class' => 'widefat d4plib-widget-save', 'name' => $this->get_field_name('post_type'), 'selected' => $instance['post_type'])); ?>
                <em><?php _e("It is not recommeded to use this widget for non-hierarchical post types or post types with large number of posts!", "gd-clever-widgets"); ?></em>
            </td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('root_content'); ?>"><?php _e("Display Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_page_hierarchy, array('id' => $this->get_field_id('root_content'), 'class' => 'widefat d4plib-block-switch', 'name' => $this->get_field_name('root_content'), 'selected' => $instance['root_content']), array('data-block' => 'root_content')); ?>
            </td>
            <td class="cell-right">
                <div class="cellblock-root_content cellblockname-full"<?php if ($instance['root_content'] != 'full') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('root_content'); ?>"><?php _e("Root Items", "gd-clever-widgets"); ?>:</label>
                    <em><?php _e("Full menu hierarchy for selected menu will always be displayed.", "gd-clever-widgets"); ?></em>
                </div>

                <div class="cellblock-root_content cellblockname-custom"<?php if ($instance['root_content'] != 'custom') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('root_item'); ?>"><?php _e("Custom Root Items Parent", "gd-clever-widgets"); ?>:</label>
                    <?php

                        $attr = array('show_option_none' => __("Nothing Selected", "gd-clever-widgets"), 'post_type' => $instance['post_type'], 'id' => $this->get_field_id('root_item'), 'name' => $this->get_field_name('root_item'), 'selected' => $instance['root_item'], 'echo' => 0);
                        $display = wp_dropdown_pages($attr);

                        if ($display == '') {
                            echo '<em>'.__("There are no parent items available right now.", "gd-clever-widgets").'</em>';
                        } else {
                            echo $display;
                        }

                    ?>

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
<h4><?php _e("Items Display", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('level_first'); ?>"><?php _e("Items to show on first level", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('level_first'); ?>" name="<?php echo $this->get_field_name('level_first'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['level_first']); ?>" />
                <em><?php _e("Leave at 0 to show all available items.", "gd-clever-widgets"); ?></em>

                <label for="<?php echo $this->get_field_id('level_inner'); ?>"><?php _e("Items to show on inner levels", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('level_inner'); ?>" name="<?php echo $this->get_field_name('level_inner'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['level_inner']); ?>" />
                <em><?php _e("Leave at 0 to show all available items.", "gd-clever-widgets"); ?></em>

                <label for="<?php echo $this->get_field_id('sort_column'); ?>"><?php _e("Sort Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_column, array('id' => $this->get_field_id('sort_column'), 'class' => 'widefat', 'name' => $this->get_field_name('sort_column'), 'selected' => $instance['sort_column'])); ?>

                <label for="<?php echo $this->get_field_id('sort_order'); ?>"><?php _e("Sort Order", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_order, array('id' => $this->get_field_id('sort_order'), 'class' => 'widefat', 'name' => $this->get_field_name('sort_order'), 'selected' => $instance['sort_order'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e("Posts To Exclude", "gd-clever-widgets"); ?>:</label>
                <?php

                    $attr = array('css_style' => 'height: 175px;', 'multiple' => 1, 'post_type' => $instance['post_type'], 'id' => $this->get_field_id('exclude'), 'name' => $this->get_field_name('exclude').'[]', 'selected' => $instance['exclude'], 'hierarchical' => 1);
                    gdclw_multiselect_pages($attr);

                ?>
                <em><?php _e("Select one or more items to exclude. Excluding one post, exlcudes all its children posts.", "gd-clever-widgets"); ?></em>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Misc Settings", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('show_description'); ?>"><?php _e("Show Excerpt", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select(gdclw_plugin()->select_yesno(), array('id' => $this->get_field_id('show_description'), 'class' => 'widefat', 'name' => $this->get_field_name('show_description'), 'selected' => $instance['show_description'])); ?>
            </td>
            <td class="cell-right">
                
            </td>
        </tr>
    </tbody>
</table>
