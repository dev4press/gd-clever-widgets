<?php

$list_sort_column = array(
    'none' => __("No Sorting", "gd-clever-widgets"), 
    'ID' => __("Post ID", "gd-clever-widgets"), 
    'title' => __("Post Title", "gd-clever-widgets"), 
    'name' => __("Post Slug", "gd-clever-widgets"), 
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

$list_post_thumbnail = array(
    'any' => __("Either Way", "gd-clever-widgets"),
    'yes' => __("Assigned", "gd-clever-widgets"),
    'no' => __("Not Assigned", "gd-clever-widgets")
);

?>
<h4><?php _e("Additional Options", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e("Limit Number of Posts", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['limit']); ?>" />
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e("Post Thumbnail Assigned", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_post_thumbnail, array('id' => $this->get_field_id('thumbnail'), 'class' => 'widefat', 'name' => $this->get_field_name('thumbnail'), 'selected' => $instance['thumbnail'])); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Sorting", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('sort_column'); ?>"><?php _e("Sort Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_column, array('id' => $this->get_field_id('sort_column'), 'class' => 'widefat', 'name' => $this->get_field_name('sort_column'), 'selected' => $instance['sort_column'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('sort_order'); ?>"><?php _e("Sort Order", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_sort_order, array('id' => $this->get_field_id('sort_order'), 'class' => 'widefat', 'name' => $this->get_field_name('sort_order'), 'selected' => $instance['sort_order'])); ?>
            </td>
        </tr>
    </tbody>
</table>
