<?php

$list_sort_order = array(
    'DESC' => __("Descending", "gd-clever-widgets"), 
    'ASC' => __("Ascending", "gd-clever-widgets")
);

$list_sort_select = array(
    'name' => __("Name", "gd-clever-widgets"), 
    'count' => __("Count", "gd-clever-widgets"), 
    'none' => __("None", "gd-clever-widgets"), 
    'id' => __("ID", "gd-clever-widgets"), 
    'slug' => __("Slug", "gd-clever-widgets")
);

$list_sort_orderby = array(
    'name' => __("Name", "gd-clever-widgets"), 
    'count' => __("Count", "gd-clever-widgets"), 
    'RAND' => __("Random", "gd-clever-widgets")
);

?>

<h4><?php _e("Taxonomies to include", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <?php

                $taxonomies = get_taxonomies(array('public' => true), 'objects');

                foreach ($taxonomies as $tax => $obj) {
                    if (!in_array($tax, array('post_format'))) {
                        $checked = in_array($tax, $instance['taxonomies']) ? ' checked="checked"' : '';

                ?>

                <label for="<?php echo $this->get_field_id('taxonomies'); ?>_<?php echo $tax; ?>">
                    <input<?php echo $checked; ?> type="checkbox" name="<?php echo $this->get_field_name('taxonomies'); ?>[]" id="<?php echo $this->get_field_id('taxonomies'); ?>_<?php echo $tax; ?>" value="<?php echo $tax; ?>" /> 
                    <?php echo $obj->label.' ('.$tax.')'; ?></label>

                <?php

                    }
                }

                ?>
            </td>
        </tr>
    </tbody>
</table>  

<h4><?php _e("Terms Filtering", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e("Terms to show", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['number']); ?>" />
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e("Minimal number of posts", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['posts']); ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('select'); ?>"><?php _e("Terms Selection Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_select, array('id' => $this->get_field_id('select'), 'class' => 'widefat', 'name' => $this->get_field_name('select'), 'selected' => $instance['select'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('select_order'); ?>"><?php _e("Select Order", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_order, array('id' => $this->get_field_id('select_order'), 'class' => 'widefat', 'name' => $this->get_field_name('select_order'), 'selected' => $instance['select_order'])); ?>
            </td>
        </tr>
    </tbody>
</table>  

<h4><?php _e("Additional Options", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e("Sort Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_orderby, array('id' => $this->get_field_id('orderby'), 'class' => 'widefat', 'name' => $this->get_field_name('orderby'), 'selected' => $instance['orderby'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e("Sort Order", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_order, array('id' => $this->get_field_id('order'), 'class' => 'widefat', 'name' => $this->get_field_name('order'), 'selected' => $instance['order'])); ?>
            </td>
        </tr>
        <tr>
            <td class="cell-singular" colspan="2">
                <label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e("Exclude by Term ID (comma separated)", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" type="text" value="<?php echo esc_attr(join(', ', $instance['exclude'])); ?>" />
            </td>
        </tr>
    </tbody>
</table>