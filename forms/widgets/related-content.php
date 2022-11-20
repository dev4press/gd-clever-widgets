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
                    <?php _e("Widget will try to display related posts only for single posts (or pages) belonging to selected post types.", "gd-clever-widgets"); ?>
                </em>
            </td>
        </tr>
    </tbody>
</table>