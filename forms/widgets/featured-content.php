<h4><?php _e("Post to display", "gd-clever-widgets"); ?></h4>
<table class="gdclw-post-info">
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('post'); ?>"><?php _e("Post ID", "gd-clever-widgets"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('post'); ?>" name="<?php echo $this->get_field_name('post'); ?>" type="number" min="0" step="1" value="<?php echo esc_attr($instance['post']); ?>" />
            </td>
            <td class="cell-right">
                <label><?php _e("Post Title", "gd-clever-widgets"); ?>:</label>
                <span><?php

                if ($instance['post'] == 0) {
                    _e("No post selected for display.", "gd-clever-widgets");
                } else {
                    $post = get_post($instance['post']);

                    if ($post) {
                        echo $post->post_title;
                    } else {
                        _e("Invalid post ID.", "gd-clever-widgets");
                    }
                }

                ?></span>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Search for post", "gd-clever-widgets"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">

<div class="gdclw-post-search">
    <input class="widefat" type="text" value="" data-nonce="<?php echo wp_create_nonce('internal-linking'); ?>" />
</div>
<div class="gdclw-post-search-results">
    
</div>

            </td>
        </tr>
    </tbody>
</table>