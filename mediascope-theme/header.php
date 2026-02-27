<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'mediascope'); ?></a>

    <header class="site-header" id="site-header">
        <div class="header-inner">
            <div class="site-branding">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                    <?php
                    $logo = get_theme_mod('custom_logo');
                    if ($logo) {
                        echo wp_get_attachment_image($logo, 'full', false, array('alt' => get_bloginfo('name')));
                    } else {
                        // Default logo SVG
                        ?>
                        <svg width="180" height="40" viewBox="0 0 180 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 8L20 16L10 24V8Z" fill="white"/>
                            <path d="M20 16L30 8V24L20 16Z" fill="white" fill-opacity="0.7"/>
                            <text x="38" y="24" fill="white" font-family="Inter" font-weight="600" font-size="18">mediascope</text>
                        </svg>
                        <?php
                    }
                    ?>
                </a>
            </div>

            <nav class="main-navigation" id="main-navigation">
                <button class="menu-toggle" id="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        // Default menu if no menu is set
                        ?>
                        <ul class="nav-menu">
                            <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
                            <li><a href="<?php echo esc_url(home_url('/media/')); ?>">Media</a></li>
                            <li><a href="<?php echo esc_url(home_url('/solutions/')); ?>">Solutions</a></li>
                            <li><a href="<?php echo esc_url(home_url('/insights/')); ?>">Insights</a></li>
                            <li><a href="<?php echo esc_url(home_url('/case-study/')); ?>">Case Study</a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="contact-btn">Contact</a></li>
                        </ul>
                        <?php
                    },
                ));
                ?>
            </nav>
        </div>
    </header>

    <script>
    // Header scroll effect
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('site-header');
        const menuToggle = document.getElementById('menu-toggle');
        const mainNav = document.getElementById('main-navigation');
        
        // Scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Mobile menu toggle
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                mainNav.classList.toggle('active');
                const isExpanded = mainNav.classList.contains('active');
                menuToggle.setAttribute('aria-expanded', isExpanded);
            });
        }
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!header.contains(e.target) && mainNav.classList.contains('active')) {
                mainNav.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
    </script>
