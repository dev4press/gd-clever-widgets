<div class="clw-authors-single">
    <?php

    if ($instance['show_avatar']) {
        echo get_avatar($user, $instance['avatar_size']);
    }

    echo '<h3>'.esc_html($user->display_name).'</h3>';
    echo '<em>'.sprintf(_n("%s post published", "%s posts published", $user_posts, "gd-clever-widgets"), $user_posts).'</em>';

    if ($instance['show_description'] && !empty($user->description)) {
        echo '<p>'.esc_html($user->description).'</p>';
    }

    if ($instance['show_recent']) {
        $args = array(
            'ignore_sticky_posts' => true,
            'author' => $user_id,
            'order' => 'DESC',
            'posts_per_page' => $instance['recent_posts'],
            'post_type' => isset($instance['post_types']) ? $instance['post_types'] : 'post',
            'post_status' => 'publish'
        );

        $recent_posts = new WP_Query($args);

        if ($recent_posts->have_posts()) :
            echo '<h6>'.__("Recently published", "gd-clever-widgets").'</h6>';
            echo '<ul>';

            while ($recent_posts->have_posts()) : $recent_posts->the_post();
                echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
            endwhile;

            echo '</ul>';
        endif;

        wp_reset_postdata();
    }

    echo '<a class="clw-archives-button" href="'.get_author_posts_url($user_id).'">'.__("Author Archives", "gd-clever-widgets").'</a>';

    ?>
</div>