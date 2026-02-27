<?php
/**
 * The template for displaying archive pages
 *
 * @package Mediascope
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            
            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header>
            
            <div class="posts-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <header class="entry-header">
                                <?php
                                the_category(', ');
                                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                ?>
                                <div class="entry-meta">
                                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                                </div>
                            </header>
                            
                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <footer class="entry-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    <?php esc_html_e('Read More', 'mediascope'); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </footer>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>
            
            <?php
            the_posts_pagination(array(
                'prev_text' => '<span class="screen-reader-text">' . esc_html__('Previous page', 'mediascope') . '</span>',
                'next_text' => '<span class="screen-reader-text">' . esc_html__('Next page', 'mediascope') . '</span>',
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'mediascope') . ' </span>',
            ));
            
        else :
            ?>
            <p><?php esc_html_e('No posts found.', 'mediascope'); ?></p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();