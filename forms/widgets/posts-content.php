<?php

$list_posts_filters = array(
    'post_type' => __("Post Type", "gd-clever-widgets"),
    'post_ids' => __("Post ID's List", "gd-clever-widgets"),
);

?>
<h4><?php _e("Posts to Display", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e("Retrieve Posts by", "gd-clever-widgets"); ?>:</label>
                <?php d4p_render_select($list_posts_filters, array('id' => $this->get_field_id('filter'), 'class' => 'widefat d4plib-block-switch gdclw-auto-save', 'name' => $this->get_field_name('filter'), 'selected' => $instance['filter']), array('data-block' => 'filter')); ?>
            </td>
            <td class="cell-right">
                <div class="cellblock-filter cellblockname-post_type"<?php if ($instance['filter'] != 'post_type') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e("Post Type", "gd-clever-widgets"); ?>:</label>
                    <?php d4p_render_select(gdcls_list_post_types(), array('id' => $this->get_field_id('post_type'), 'class' => 'widefat gdclw-auto-save', 'name' => $this->get_field_name('post_type'), 'selected' => $instance['post_type'])); ?>
                </div>
                <div class="cellblock-filter cellblockname-post_ids"<?php if ($instance['filter'] != 'post_ids') { echo ' style="display: none"'; } ?>>
                    <label for="<?php echo $this->get_field_id('post_ids'); ?>"><?php _e("Post ID's", "gd-clever-widgets"); ?>:</label>
                    <input class="widefat" id="<?php echo $this->get_field_id('post_ids'); ?>" name="<?php echo $this->get_field_name('post_ids'); ?>" type="text" value="<?php echo esc_attr($instance['post_ids']); ?>" />
                    <em><?php _e("Comma separated list of post ID's", "gd-clever-widgets"); ?></em>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<?php

if ($instance['filter'] == 'post_type') {

?>

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

<?php

    $taxonomies = get_object_taxonomies($instance['post_type']);

    foreach ($taxonomies as $tax) {
        $obj = get_taxonomy($tax);

?>

<h4><?php echo __("Filter by", "gd-clever-widgets").' '.$obj->labels->singular_name; ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="gdclw-term-search">
                    <input class="widefat" type="text" value="" data-tax="<?php echo $tax; ?>" />
                    <input type="button" value="<?php echo _("Add"); ?>" class="button-secondary" />
                </div>
                <div class="gdclw-term-single" style="display: none;">
                    <input type="hidden" name="<?php echo $this->get_field_name('terms').'['.$tax.'][in][]'; ?>" />
                    <span class="gdclw-operator">+</span>
                    <span class="gdclw-term"><span></span> - <a href="#"><?php _e("remove", "gd-clever-widgets"); ?></a></span>
                </div>
            </td>
            <td class="cell-right">
                <div class="gdclw-term-list">
                    <?php

                    if (isset($instance['terms'][$tax])) {
                        foreach ($instance['terms'][$tax] as $operator => $terms) {
                            foreach ($terms as $term_id) { 
                                $sign = $operator == 'in' ? '+' : '-';
                                $term = get_term($term_id, $tax); ?>

                    <div class="gdclw-term-single">
                        <input type="hidden" name="<?php echo $this->get_field_name('terms').'['.$tax.']['.$operator.'][]'; ?>" value="<?php echo esc_attr($term->name); ?>" />
                        <span class="gdclw-operator"><?php echo $sign; ?></span>
                        <span class="gdclw-term"><span><?php echo $term->name; ?></span> - <a href="#"><?php _e("remove", "gd-clever-widgets"); ?></a></span>
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
<?php } } 