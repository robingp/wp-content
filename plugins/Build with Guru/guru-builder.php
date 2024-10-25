<?php
/**
 * Plugin Name: Build With Guru
 * Description: A plugin to manage headers, footers, and blocks with customizable options using Elementor.
 * Version: 1.1
 * Author: Your Name
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register custom post types for Header and Footer
function guru_builder_register_post_types() {
    // Header post type
    register_post_type( 'guru_header', array(
        'labels' => array(
            'name'               => __( 'Headers', 'guru_builder' ),
            'singular_name'      => __( 'Header', 'guru_builder' ),
            'add_new'            => __( 'Add New', 'guru_builder' ),
            'edit_item'          => __( 'Edit Header', 'guru_builder' ),
            'all_items'          => __( 'All Headers', 'guru_builder' ),
        ),
        'public'             => true,
        'has_archive'        => false,
        'supports'           => array( 'title', 'editor' ),
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-editor-insertmore', // Icon for the menu
    ));

    // Footer post type
    register_post_type( 'guru_footer', array(
        'labels' => array(
            'name'               => __( 'Footers', 'guru_builder' ),
            'singular_name'      => __( 'Footer', 'guru_builder' ),
            'add_new'            => __( 'Add New', 'guru_builder' ),
            'edit_item'          => __( 'Edit Footer', 'guru_builder' ),
            'all_items'          => __( 'All Footers', 'guru_builder' ),
        ),
        'public'             => true,
        'has_archive'        => false,
        'supports'           => array( 'title', 'editor' ),
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-editor-insertmore', // Icon for the menu
    ));
}
add_action( 'init', 'guru_builder_register_post_types' );

// Output the header content
function guru_builder_display_header() {
    // Fetch the latest header post
    $header_query = new WP_Query( array(
        'post_type' => 'guru_header',
        'posts_per_page' => 1,
    ));

    if ( $header_query->have_posts() ) {
        echo '<header class="guru-builder-header">';
        while ( $header_query->have_posts() ) {
            $header_query->the_post();
            echo '<div>' . apply_filters( 'the_content', get_the_content() ) . '</div>'; // Display header content with Elementor
        }
        echo '</header>';
    }

    // Restore original post data
    wp_reset_postdata();
}
add_action( 'wp_head', 'guru_builder_display_header' );

// Output the footer content
function guru_builder_display_footer() {
    // Fetch the latest footer post
    $footer_query = new WP_Query( array(
        'post_type' => 'guru_footer',
        'posts_per_page' => 1,
    ));

    if ( $footer_query->have_posts() ) {
        echo '<footer class="guru-builder-footer">';
        while ( $footer_query->have_posts() ) {
            $footer_query->the_post();
            echo '<div>' . apply_filters( 'the_content', get_the_content() ) . '</div>'; // Display footer content with Elementor
        }
        echo '</footer>';
    }

    // Restore original post data
    wp_reset_postdata();
}
add_action( 'wp_footer', 'guru_builder_display_footer' );
