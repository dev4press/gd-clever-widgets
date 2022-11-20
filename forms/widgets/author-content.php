<?php

$list_author_method = array(
    'auto' => __("Current Author", "gd-clever-widgets"), 
    'select' => __("Selected Author", "gd-clever-widgets")
);

?>

<h4><?php _e("Sorting", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('method'); ?>"><?php _e("Author Selection Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_author_method, array('id' => $this->get_field_id('method'), 'class' => 'widefat', 'name' => $this->get_field_name('method'), 'selected' => $instance['method'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('author'); ?>"><?php _e("Select Author", "gd-clever-widgets"); ?>:</label>
                <?php wp_dropdown_users(array('id' => $this->get_field_id('author'), 'class' => 'widefat', 'name' => $this->get_field_name('author'), 'selected' => $instance['author'])); ?>
            </td>
        </tr>
    </tbody>
</table>
