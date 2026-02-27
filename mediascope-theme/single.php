<?php
/**
 * The template for displaying all single posts
 *
 * @package Mediascope
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php
                    the_category(', ');
                    the_title('<h1 class="entry-title">', '</h1>');
                    ?>
                    <div class="entry-meta">
                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                        <span class="byline"><?php echo get_the_author(); ?></span>
                    </div>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'mediascope'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
                
                <footer class="entry-footer">
                    <?php mediascope_entry_footer(); ?>
                </footer>
            </article>
            
            <nav class="navigation post-navigation">
                <h2 class="screen-reader-text"><?php esc_html_e('Post navigation', 'mediascope'); ?></h2>
                <div class="nav-links">
                    <?php
                    previous_post_link('<div class="nav-previous">%link</div>', '%title');
                    next_post_link('<div class="nav-next">%link</div>', '%title');
                    ?>
                </div>
            </nav>
            
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();

/**
 * Display post categories and tags
 */
function mediascope_entry_footer() {
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__(', ', 'mediascope'));
        if ($categories_list) {
            printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'mediascope') . '</span>', $categories_list);
        }
        
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'mediascope'));
        if ($tags_list) {
            printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'mediascope') . '</span>', $tags_list);
        }
    }
    
    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mediascope'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );
        echo '</span>';
    }
    
    edit_post_link(
        sprintf(
            wp_kses(
                __('Edit <span class="screen-reader-text">%s</span>', 'mediascope'),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            get_the_title()
        ),
        '<span class="edit-link">',
        '</span>'
    );
}