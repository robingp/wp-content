<?php

// Prevent function redeclaration by checking if the function already exists
if ( ! function_exists( 'my_custom_theme_setup' ) ) {
    function my_custom_theme_setup() {
        // Add theme support for post thumbnails (featured images)
        add_theme_support( 'post-thumbnails' );

        // Add theme support for HTML5 features
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Register navigation menus for the theme
        register_nav_menus( array(
            'main-menu'   => __( 'Main Menu', 'my-custom-theme' ),
            'footer-menu' => __( 'Footer Menu', 'my-custom-theme' ),
        ));

        // Add support for a custom logo
        add_theme_support( 'custom-logo', array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        ));

        // Add support for title tag and automatic feed links
        add_theme_support( 'title-tag' );
        add_theme_support( 'automatic-feed-links' );
    }
}
add_action( 'after_setup_theme', 'my_custom_theme_setup' );

// Enqueue styles and scripts
function my_custom_theme_enqueue_styles() {
    // Main stylesheet
    wp_enqueue_style( 'main-styles', get_stylesheet_uri() );
    wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/css/custom-style.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'my_custom_theme_enqueue_styles' );

// Register a custom post type for Projects
function my_custom_post_type() {
    $labels = array(
        'name'               => 'Projects',
        'singular_name'      => 'Project',
        'menu_name'          => 'Projects',
        'add_new'            => 'Add New',
        'edit_item'          => 'Edit Project',
        'all_items'          => 'All Projects',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'rewrite'            => array( 'slug' => 'projects' ),
        'has_archive'        => true,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
    );

    register_post_type( 'project', $args );
}
add_action( 'init', 'my_custom_post_type' );

// Register a custom taxonomy for Project Types
function my_custom_taxonomy() {
    $labels = array(
        'name'              => 'Project Types',
        'singular_name'     => 'Project Type',
        'all_items'         => 'All Project Types',
        'edit_item'         => 'Edit Project Type',
    );

    $args = array(
        'hierarchical'      => true, // Like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'rewrite'           => array( 'slug' => 'project-type' ),
    );

    register_taxonomy( 'project_type', array( 'project' ), $args );
}
add_action( 'init', 'my_custom_taxonomy' );

// Theme Customizer Settings
function my_custom_theme_customizer( $wp_customize ) {
    // Title Section
    $wp_customize->add_section('title_settings', array(
        'title'    => __('Title Colors', 'my-custom-theme'),
        'priority' => 30,
    ));

    // Title and Heading Colors
    $colors = [
        'title_color'     => '#000000',
        'paragraph_color' => '#000000',
    ];
    for ($i = 1; $i <= 6; $i++) {
        $colors["h{$i}_color"] = '#000000';
    }

    foreach ($colors as $key => $default) {
        $wp_customize->add_setting($key, array(
            'default'           => $default,
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "{$key}_control", array(
            'label'    => __( ucfirst(str_replace('_', ' ', $key)), 'my-custom-theme' ),
            'section'  => 'title_settings',
            'settings' => $key,
        )));
    }

    // Add Background Color for Each Page/Post
    $pages = get_pages();
    foreach ($pages as $page) {
        $wp_customize->add_setting("background_color_{$page->ID}", array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "background_color_{$page->ID}_control", array(
            'label'    => sprintf(__('Background Color for %s', 'my-custom-theme'), $page->post_title),
            'section'  => 'title_settings',
            'settings' => "background_color_{$page->ID}",
        )));
    }

    // Modify Site Identity section to include favicon and exit title
    $wp_customize->get_section('title_tagline')->title = __('Site Identity & Tab Exit Settings', 'my-custom-theme');

    // Favicon for tab exit
    $wp_customize->add_setting('exit_favicon', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'exit_favicon_control', array(
        'label'    => __('Exit Tab Favicon', 'my-custom-theme'),
        'section'  => 'title_tagline',
        'settings' => 'exit_favicon',
    )));
    $wp_customize->add_control('favicon_dimensions_note', array(
        'label'    => __('Recommended Dimensions: 16x16 pixels, 32x32 pixels, or 48x48 pixels', 'my-custom-theme'),
        'section'  => 'title_tagline',
        'type'     => 'description',
    ));

    // Title for tab exit
    $wp_customize->add_setting('exit_title', array(
        'default'           => __('Come Back!', 'my-custom-theme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('exit_title_control', array(
        'label'    => __('Exit Tab Title', 'my-custom-theme'),
        'section'  => 'title_tagline',
        'settings' => 'exit_title',
        'type'     => 'text',
    ));

    // Font Settings Section
    $wp_customize->add_section('custom_font_settings', array(
        'title'    => __('Font Settings', 'my-custom-theme'),
        'priority' => 80,
    ));

    // Font Settings for Tags
    $tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p'];

    foreach ($tags as $tag) {
        // Font Family Setting
        $wp_customize->add_setting("{$tag}_font_family", array(
            'default'           => 'Arial',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("{$tag}_font_family_control", array(
            'label'    => __("Select Font Family for {$tag}", 'my-custom-theme'),
            'section'  => 'custom_font_settings',
            'settings' => "{$tag}_font_family",
            'type'     => 'select',
            'choices'  => array(
                'Arial' => 'Arial',
                'Georgia' => 'Georgia',
                'Times New Roman' => 'Times New Roman',
                'Verdana' => 'Verdana',
                'Courier New' => 'Courier New',
                'Poppins' => 'Poppins',
                'Roboto' => 'Roboto',
                'Raleway' => 'Raleway',
            ),
        ));

        // Font Size Setting
        $wp_customize->add_setting("{$tag}_font_size", array(
            'default'           => '16px',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("{$tag}_font_size_control", array(
            'label'    => __("Font Size for {$tag}", 'my-custom-theme'),
            'section'  => 'custom_font_settings',
            'settings' => "{$tag}_font_size",
            'type'     => 'text',
        ));

        // Font Weight Setting
        $wp_customize->add_setting("{$tag}_font_weight", array(
            'default'           => 'normal',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("{$tag}_font_weight_control", array(
            'label'    => __("Font Weight for {$tag}", 'my-custom-theme'),
            'section'  => 'custom_font_settings',
            'settings' => "{$tag}_font_weight",
            'type'     => 'select',
            'choices'  => array(
                'normal' => 'Normal',
                'bold'   => 'Bold',
                'bolder' => 'Bolder',
                'lighter' => 'Lighter',
            ),
        ));
    }
}
add_action( 'customize_register', 'my_custom_theme_customizer' );

// Output custom styles in the head
function my_custom_customizer_css() {
    ?>
    <style type="text/css">
        <?php
        // Output colors for headings and paragraphs
        for ($i = 1; $i <= 6; $i++) {
            echo "h{$i} { color: " . get_theme_mod("h{$i}_color", '#000000') . "; }";
        }
        echo "h1, h2, h3, h4, h5, h6 { color: " . get_theme_mod('title_color', '#000000') . "; }";
        echo "p { color: " . get_theme_mod('paragraph_color', '#000000') . "; }";

        // Output background colors for pages
        $pages = get_pages();
        foreach ($pages as $page) {
            echo "#page-{$page->ID} { background-color: " . get_theme_mod("background_color_{$page->ID}", '#ffffff') . "; }";
        }

        // Output font styles for tags
        $tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p'];
        foreach ($tags as $tag) {
            echo "{$tag} { ";
            echo "font-family: " . get_theme_mod("{$tag}_font_family", 'Arial') . "; ";
            echo "font-size: " . get_theme_mod("{$tag}_font_size", '16px') . "; ";
            echo "font-weight: " . get_theme_mod("{$tag}_font_weight", 'normal') . "; ";
            echo "}";
        }
        ?>
    </style>
    <?php
}
add_action('wp_head', 'my_custom_customizer_css');


// Add custom scripts
function my_custom_theme_scripts() {
    ?>
    <script type="text/javascript">
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                // Change favicon
                var exitFaviconUrl = "<?php echo esc_url(get_theme_mod('exit_favicon')); ?>";
                var link = document.querySelector('link[rel="icon"]') || document.createElement('link');
                link.type = 'image/png';
                link.rel = 'icon';
                link.href = exitFaviconUrl;
                document.head.appendChild(link);

                // Change tab title
                document.title = "<?php echo esc_js(get_theme_mod('exit_title')); ?>";
            } else {
                // Reset favicon and title when tab is active again
                var defaultFavicon = "<?php echo esc_url(get_site_icon_url()); ?>";
                document.querySelector('link[rel="icon"]').href = defaultFavicon;
                document.title = "<?php bloginfo('name'); ?>";
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'my_custom_theme_scripts');
