<?php

$list_post_terms_relationship = array(
    'OR' => __("OR", "gd-clever-widgets"), 
    'AND' => __("AND", "gd-clever-widgets")
);

$list_post_keywords_search = array(
    'auto' => __("Automatic", "gd-clever-widgets"), 
    'off' => __("Disabled", "gd-clever-widgets")
);

?>
<h4><?php _e("Relations Filtering", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('terms_relationship'); ?>"><?php _e("Terms Relationship", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_post_terms_relationship, array('id' => $this->get_field_id('terms_relationship'), 'class' => 'widefat', 'name' => $this->get_field_name('terms_relationship'), 'selected' => $instance['terms_relationship'])); ?>
            </td>
            <td class="cell-right">&nbsp;</td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Keywords Search", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('keywords_search'); ?>"><?php _e("Search Method", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_post_keywords_search, array('id' => $this->get_field_id('keywords_search'), 'class' => 'widefat', 'name' => $this->get_field_name('keywords_search'), 'selected' => $instance['keywords_search'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('keywords_limit'); ?>"><?php _e("Limit Number of Keywords", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('keywords_limit'); ?>" name="<?php echo $this->get_field_name('keywords_limit'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['keywords_limit']); ?>" />
            </td>
        </tr>
    </tbody>
</table>
