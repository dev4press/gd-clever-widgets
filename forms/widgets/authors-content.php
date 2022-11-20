<?php

$list_sort_column = array(
    'none' => __("No Sorting", "gd-clever-widgets"), 
    'posts' => __("Posts count", "gd-clever-widgets"), 
    'u.ID' => __("User ID", "gd-clever-widgets"), 
    'u.user_login' => __("User Login", "gd-clever-widgets")
);

$list_sort_order = array(
    'DESC' => __("Descending", "gd-clever-widgets"), 
    'ASC' => __("Ascending", "gd-clever-widgets")
);

?>

<h4><?php _e("Post types", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="d4plib-checkbox-list">
                <?php

                foreach (gdcls_list_post_types() as $cpt => $name) {
                    $checked = in_array($cpt, $instance['post_types']) ? ' checked="checked"' : '';
                    echo '<label><input'.$checked.' type="checkbox" name="'.$this->get_field_name('post_types').'[]" value="'.$cpt.'" />'.$name.'</label>';
                }

                ?>
                </div>
            </td>
            <td class="cell-right">
                <em>
                    <?php _e("Widget will match authors that have posts belonging to selected post types, all other authors will be ignored. Additional filters will be used also.", "gd-clever-widgets"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Filter Authors", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="gdclw-author-search">
                    <input class="widefat" type="text" value="" />
                    <input type="button" value="<?php echo _("Add"); ?>" class="button-secondary" />
                    <em><?php _e("Include or exclude authors, don't mix the two. If some authors are marked for exclusion, included authors will not be used. This is how WP_Query works.", "gd-clever-widgets"); ?></em>
                </div>
                <div class="gdclw-term-single" style="display: none;">
                    <input type="hidden" name="<?php echo $this->get_field_name('authors').'[in][]'; ?>" />
                    <span class="gdclw-operator">+</span>
                    <span class="gdclw-term"><span></span> - <a href="#"><?php _e("remove", "gd-clever-widgets"); ?></a></span>
                </div>
            </td>
            <td class="cell-right">
                <div class="gdclw-term-list">
                    <?php

                    if (isset($instance['authors'])) {
                        foreach ($instance['authors'] as $operator => $authors) {
                            foreach ($authors as $author_id) {
                                $sign = $operator == 'in' ? '+' : '-';
                                $author = get_user_by('id', $author_id); ?>

                        <div class="gdclw-term-single">
                            <input type="hidden" name="<?php echo $this->get_field_name('authors').'['.$operator.'][]'; ?>" value="<?php echo esc_attr($author->user_login); ?>" />
                            <span class="gdclw-operator"><?php echo $sign; ?></span>
                            <span class="gdclw-term"><span><?php echo $author->user_login; ?></span> - <a href="#"><?php _e("remove", "gd-clever-widgets"); ?></a></span>
                        </div>

                        <?php }
                        }
                    }

                    ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Additional Options", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e("Limit Number of Authors", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['limit']); ?>" />
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('min_posts'); ?>"><?php _e("Minimal posts for inclusion", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('min_posts'); ?>" name="<?php echo $this->get_field_name('min_posts'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['min_posts']); ?>" />
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
