<?php get_header(); ?>

<main id="primary" class="site-main">
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background">
            <?php 
            $hero_image = get_theme_mod('hero_background_image', get_template_directory_uri() . '/assets/images/hero-bg.jpg');
            ?>
            <img src="<?php echo esc_url($hero_image); ?>" alt="Mediascope Hero">
        </div>
        <div class="hero-content">
            <h1 class="hero-title"><?php echo get_theme_mod('hero_title', 'Connecting Brands To The World'); ?></h1>
            <p class="hero-subtitle"><?php echo get_theme_mod('hero_subtitle', 'Media. Culture. Impact.'); ?></p>
            <a href="<?php echo esc_url(get_theme_mod('hero_button_url', '/case-study/')); ?>" class="hero-cta">
                <span><?php echo get_theme_mod('hero_button_text', 'Success Stories'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about-section" id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <div class="section-header">
                        <h2 class="section-title"><?php echo get_theme_mod('about_title', 'Reaching Audiences that Matter'); ?></h2>
                        <p class="section-subtitle"><?php echo get_theme_mod('about_subtitle', 'From C-suite Leaders To Trendsetters, Wherever They Are'); ?></p>
                    </div>
                    <div class="about-buttons">
                        <a href="<?php echo esc_url(get_theme_mod('about_button1_url', '/about/')); ?>" class="btn btn-primary">
                            <?php echo get_theme_mod('about_button1_text', 'Our Team'); ?>
                        </a>
                        <a href="<?php echo esc_url(get_theme_mod('about_button2_url', '/solutions/')); ?>" class="btn btn-outline">
                            <?php echo get_theme_mod('about_button2_text', 'Our Solutions'); ?>
                        </a>
                    </div>
                </div>
                <div class="about-text">
                    <?php echo wp_kses_post(get_theme_mod('about_content', 'We connect brands with the world\'s most influential audiences, from decision-makers across global markets to India\'s dynamic consumer base. Bespoke media solutions blend global expertise with local nuance, delivering impactful campaigns across digital, print, and experiential platforms. With a team of strategists, creatives, and analysts, we drive brand awareness and deep engagement in an ever-evolving media landscape.')); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Studies Section -->
    <section class="section case-studies-section" id="case-studies">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Success<br>Stories</h2>
                <p class="section-subtitle">Creative brand staging at almost all touchpoints along the customer journey.</p>
            </div>
            <div class="case-studies-grid">
                <?php
                $case_studies = new WP_Query(array(
                    'post_type' => 'case_study',
                    'posts_per_page' => 3,
                ));
                
                if ($case_studies->have_posts()) :
                    while ($case_studies->have_posts()) : $case_studies->the_post();
                ?>
                    <article class="case-study-card">
                        <div class="case-study-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/case-study-placeholder.jpg" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="case-study-content">
                            <h3 class="case-study-title"><?php the_title(); ?></h3>
                            <a href="<?php the_permalink(); ?>" class="case-study-link">
                                Read Now
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Display default case studies
                    $default_cases = array(
                        array(
                            'title' => 'TIME takes a soulful journey through the many shades, tints and flavours across Incredible India with The India 100',
                            'image' => get_template_directory_uri() . '/assets/images/case-study-1.jpg',
                            'link' => '#'
                        ),
                        array(
                            'title' => 'TIME Make in India Awards',
                            'image' => get_template_directory_uri() . '/assets/images/case-study-2.jpg',
                            'link' => '#'
                        ),
                        array(
                            'title' => 'Launch and Promotions of Top Mobile Brands on GSMArena',
                            'image' => get_template_directory_uri() . '/assets/images/case-study-3.jpg',
                            'link' => '#'
                        ),
                    );
                    foreach ($default_cases as $case) :
                ?>
                    <article class="case-study-card">
                        <div class="case-study-image">
                            <img src="<?php echo esc_url($case['image']); ?>" alt="<?php echo esc_attr($case['title']); ?>">
                        </div>
                        <div class="case-study-content">
                            <h3 class="case-study-title"><?php echo esc_html($case['title']); ?></h3>
                            <a href="<?php echo esc_url($case['link']); ?>" class="case-study-link">
                                Read Now
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; endif; ?>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="<?php echo esc_url(get_theme_mod('case_studies_button_url', '/cases/')); ?>" class="btn btn-outline">
                    <?php echo get_theme_mod('case_studies_button_text', 'All Case Studies'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section services-section" id="services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our<br>Services</h2>
                <p class="section-subtitle">At Mediascope, we provide end-to-end marketing and content solutions, combining global reach with local expertise to connect your brand with diverse, influential audiences, wherever they are.</p>
            </div>
            <div class="services-grid">
                <?php
                $services = get_theme_mod('services', array(
                    array(
                        'title' => 'International Media Sales',
                        'description' => 'We represent some of the most trusted global websites, publications, and events, helping your brand break geographic barriers and connect with audiences worldwide.',
                    ),
                    array(
                        'title' => 'Domestic Media Sales',
                        'description' => 'Strategic partnerships with leading Indian media platforms to help you reach the right audience at the right time.',
                    ),
                    array(
                        'title' => 'Custom Content',
                        'description' => 'Bespoke content solutions that tell your brand story in the most engaging and impactful way.',
                    ),
                    array(
                        'title' => 'Brand Solutions & Strategy',
                        'description' => 'Comprehensive brand strategy and creative solutions that drive measurable results.',
                    ),
                    array(
                        'title' => 'Performing Arts-Based Brand Marketing',
                        'description' => 'Unique marketing experiences that blend art, culture, and commerce for unforgettable brand moments.',
                    ),
                ));
                
                foreach ($services as $service) :
                ?>
                    <div class="service-card">
                        <h3 class="service-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <?php echo esc_html($service['title']); ?>
                        </h3>
                        <p class="service-description"><?php echo esc_html($service['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section team-section" id="team">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Meet<br>Our Management</h2>
                <a href="<?php echo esc_url(get_theme_mod('team_button_url', '/about/')); ?>" class="btn btn-outline">
                    <?php echo get_theme_mod('team_button_text', 'See All'); ?>
                </a>
            </div>
            <div class="team-grid">
                <?php
                $team_members = new WP_Query(array(
                    'post_type' => 'team_member',
                    'posts_per_page' => 3,
                ));
                
                if ($team_members->have_posts()) :
                    while ($team_members->have_posts()) : $team_members->the_post();
                        $position = get_post_meta(get_the_ID(), 'team_position', true);
                ?>
                    <article class="team-card">
                        <div class="team-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large'); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/team-placeholder.jpg" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name"><?php the_title(); ?></h3>
                            <p class="team-position"><?php echo esc_html($position); ?></p>
                            <div class="team-bio">
                                <?php echo wp_trim_words(get_the_content(), 30); ?>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Display default team members
                    $default_team = array(
                        array(
                            'name' => 'KHUSHBOO GUPTA',
                            'position' => 'Business Head, Encore Studios',
                            'bio' => 'A visionary media professional with over 14 years of experience shaping impactful brand solutions initiatives across TV, Digital, BTL, and Integrated Media.',
                            'image' => get_template_directory_uri() . '/assets/images/team-1.jpg',
                        ),
                        array(
                            'name' => 'MARZBAN PATEL',
                            'position' => 'Founder and CEO',
                            'bio' => 'A consummate entrepreneur, Marzban has a strong sense of responsibility and an eye for opportunity. Creative, passionate, and competitive.',
                            'image' => get_template_directory_uri() . '/assets/images/team-2.jpg',
                        ),
                        array(
                            'name' => 'ANITA PATEL',
                            'position' => 'Founder & Executive Director',
                            'bio' => 'Anita co-founded Mediascope, managing operations and meeting every challenge of building a strong back office for a rapidly growing business.',
                            'image' => get_template_directory_uri() . '/assets/images/team-3.jpg',
                        ),
                    );
                    foreach ($default_team as $member) :
                ?>
                    <article class="team-card">
                        <div class="team-image">
                            <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                        </div>
                        <div class="team-content">
                            <h3 class="team-name"><?php echo esc_html($member['name']); ?></h3>
                            <p class="team-position"><?php echo esc_html($member['position']); ?></p>
                            <div class="team-bio">
                                <?php echo esc_html($member['bio']); ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </section>

    <!-- Insights Section -->
    <section class="section insights-section" id="insights">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Latest<br>Insights</h2>
                <p class="section-subtitle">Our passion for the industry drives everything we do. We're dedicated to sharing our insights and expertise through the latest news, research, and thought leadership in media and advertising.</p>
                <a href="<?php echo esc_url(get_theme_mod('insights_button_url', '/insights/')); ?>" class="btn btn-outline" style="margin-top: 20px;">
                    <?php echo get_theme_mod('insights_button_text', 'All Insights'); ?>
                </a>
            </div>
            <div class="insights-grid">
                <?php
                $insights = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'category_name' => 'insights',
                ));
                
                if ($insights->have_posts()) :
                    while ($insights->have_posts()) : $insights->the_post();
                ?>
                    <article class="insight-card">
                        <h3 class="insight-title"><?php the_title(); ?></h3>
                        <div class="insight-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="insight-link">
                            Read Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Display default insights
                    $default_insights = array(
                        array(
                            'title' => 'Mediascope secures The Telegraph UK India mandate',
                            'excerpt' => 'The partnership offers Indian advertisers access to 18.9 million monthly cross-platform users of the 170-year-old brand.',
                            'link' => 'https://www.medianews4u.com/mediascope-secures-exclusive-india-mandate-for-the-telegraph-uk/',
                        ),
                        array(
                            'title' => 'BBC Studios appoints Mediascope to grow India presence',
                            'excerpt' => 'The partnership opens doors for brands to tap into the BBC\'s premium multi-platform offerings.',
                            'link' => 'https://www.medianews4u.com/bbc-studios-partners-with-mediascope-to-expand-advertising-reach-in-india/',
                        ),
                        array(
                            'title' => 'India\'s luxury insider returns with Top 100 Most Powerful',
                            'excerpt' => 'Tuned in to the pulse of the industry, LuxeBook sits down with leading voices in the sector.',
                            'link' => 'https://luxebook.in/digitalcopy/Luxebook-Top100-2025/#p=1',
                        ),
                    );
                    foreach ($default_insights as $insight) :
                ?>
                    <article class="insight-card">
                        <h3 class="insight-title"><?php echo esc_html($insight['title']); ?></h3>
                        <div class="insight-excerpt">
                            <?php echo esc_html($insight['excerpt']); ?>
                        </div>
                        <a href="<?php echo esc_url($insight['link']); ?>" class="insight-link" target="_blank">
                            Read Now
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </article>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact-section" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h2 class="contact-title">let's<br>Talk</h2>
                </div>
                <div class="contact-form-wrapper">
                    <form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                        <input type="hidden" name="action" value="mediascope_contact_form">
                        <?php wp_nonce_field('mediascope_contact_nonce', 'contact_nonce'); ?>
                        
                        <div class="form-group">
                            <label for="user_type">I Would Describe Myself As</label>
                            <select name="user_type" id="user_type" required>
                                <option value="">Select an option</option>
                                <option value="advertiser">Advertiser looking for premium media partner</option>
                                <option value="business">Business owner looking for revenue partner</option>
                                <option value="brand">Brand owner looking for custom content creation</option>
                                <option value="marketer">Brand marketer looking for marketing solutions</option>
                                <option value="client">Client looking for specific solution</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <input type="text" name="first_name" placeholder="First Name" required>
                        </div>
                        
                        <div class="form-group">
                            <input type="text" name="last_name" placeholder="Last Name" required>
                        </div>
                        
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>
                        
                        <div class="form-group">
                            <select name="country" required>
                                <option value="">Select Your Country</option>
                                <?php
                                $countries = array(
                                    'India', 'United States', 'United Kingdom', 'Australia', 'Canada',
                                    'Germany', 'France', 'Japan', 'China', 'Singapore', 'UAE', 'Other'
                                );
                                foreach ($countries as $country) {
                                    echo '<option value="' . esc_attr($country) . '">' . esc_html($country) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <input type="text" name="company" placeholder="Company Name">
                        </div>
                        
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Phone Number">
                        </div>
                        
                        <div class="form-group">
                            <textarea name="message" placeholder="Your Message"></textarea>
                        </div>
                        
                        <div class="form-group form-checkbox">
                            <input type="checkbox" name="consent" id="consent" required>
                            <label for="consent">I consent to receive communication from Mediascope regarding its products, services, and promotional offers. I understand that I can withdraw my consent by <a href="#">unsubscribing</a> at any time.</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>