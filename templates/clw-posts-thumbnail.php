<article <?php post_class(); ?>>
    <?php if (current_theme_supports('post-thumbnails') && has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" title="<?php esc_attr(get_the_title()); ?>"><?php the_post_thumbnail(); ?></a>
    <?php endif; ?>
</article>
