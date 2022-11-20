<article <?php post_class(); ?>>
    <header>
        <?php if (current_theme_supports('post-thumbnails') && has_post_thumbnail()) : ?>
            <div class="entry-image">
                <a href="<?php the_permalink(); ?>" title="<?php esc_attr(get_the_title()); ?>"><?php the_post_thumbnail(array(80, 80)); ?></a>
            </div>
        <?php endif; ?>

        <h4 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h4>

        <div class="entry-meta">
            <time class="entry-date" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>, By
            <span class="entry-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a></span>
        </div>
    </header>
    <div class="entry-summary">
        <?php the_content(); ?>
    </div>
</article>
