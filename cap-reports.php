<?php
/*
Plugin Name: CAP Reports
Plugin URI: http://americanprogress.org
Description: CAP "Reports" long form content post type and editorial tools. Best when used in conjunction with CAP Content Blocks (Shortcodes).
Version: 0.1
Author: Seth Rubenstein for Center for American Progress
Author URI: http://sethrubenstein.info
*/

if ( !function_exists( 'ccb_styles_scripts' ) ) {
   add_action( 'admin_notices', function(){
       if ( current_user_can( 'activate_plugins' ) ) {
           echo '<div class="error message"><p>You dont have CAP Content Blocks active. Please activate the CCB plugin in order to use CAP Reports to its full potential.</p></div>';
       }
   });
   return;
}

$plugin_dir = plugin_dir_path( __FILE__ );

if ( ! function_exists('cr_register') ) {
    // Register Report Post Type
    function cr_register() {
        $labels = array(
            'name'                => 'Reports',
            'singular_name'       => 'Report',
            'menu_name'           => 'Reports',
            'parent_item_colon'   => 'Report:',
            'all_items'           => 'All Reports',
            'view_item'           => 'View Report',
            'add_new_item'        => 'Add New Report',
            'add_new'             => 'Add New',
            'edit_item'           => 'Edit Report',
            'update_item'         => 'Update Report',
            'search_items'        => 'Search Reports',
            'not_found'           => 'No report found',
            'not_found_in_trash'  => 'No reports found in Trash',
        );
        $rewrite = array(
            'slug'                => 'report',
            'with_front'          => true,
            'pages'               => true,
            'feeds'               => true,
        );
        $args = array(
            'label'               => 'reports',
            'description'         => 'C3 reports',
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', ),
            'taxonomies'          => array( 'category', 'post_tag' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-analytics',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => 'post',
        );
        register_post_type( 'reports', $args );
    }
    // Hook into the 'init' action
    add_action( 'init', 'cr_register', 0 );
}

include $plugin_dir.'/report-chapters.php';
include $plugin_dir.'/report-header.php';
include $plugin_dir.'/report-overview.php';
include $plugin_dir.'/report-related-content.php';
include $plugin_dir.'/helpers.php';
include $plugin_dir.'/fields.php';

function cr_editor_style() {
    add_editor_style( plugin_dir_url( __FILE__ ) . 'css/cap-reports-editor-style.css' );
}
add_action( 'admin_init', 'cr_editor_style' );

function cr_styles_scripts() {
    if (is_singular('reports')) {

        wp_register_style( 'cap-reports-theme-compat',  plugin_dir_url( __FILE__ ) . 'css/cap-reports-theme-support.css' );
        wp_register_style( 'cap-reports-full',  plugin_dir_url( __FILE__ ) . 'css/cap-reports-full.css' );

        // Check to see if the current theme has support for cap-reports
        // This can be delcared on a theme by declaring add_theme_support('cap-reports'); in functions.php
        if (current_theme_supports('cap-reports')) {
            wp_enqueue_style( 'cap-reports-theme-compat' );
        } else {
            wp_enqueue_style( 'cap-reports-full' );
        }

        if ( !wp_style_is( 'mdi', 'enqueued' ) ) {
            wp_enqueue_style( 'mdi',  plugin_dir_url( __FILE__ ) . 'bower_components/mdi/css/materialdesignicons.min.css' );
        }

        // We need to check for enquire js and vide before enqueuing
        wp_enqueue_script( 'cap-reports', plugin_dir_url( __FILE__ ) . 'js/cap-reports.js', array('jquery'), '20150210', true );

        if ( !wp_script_is( 'vide', 'enqueued' ) ) {
            wp_enqueue_script( 'vide', plugin_dir_url( __FILE__ ) . 'bower_components/vide/dist/jquery.vide.min.js', array('jquery'), '20150210', true );
        }

        if ( !wp_script_is( 'enquire.js', 'enqueued' ) ) {
            wp_enqueue_script( 'enquire.js', plugin_dir_url( __FILE__ ) . 'bower_components/enquire/dist/enquire.min.js', array('jquery'), '20150210', true );
        }

    }
}
add_action( 'wp_enqueue_scripts', 'cr_styles_scripts' );

function cr_image_sizes() {
    add_image_size('header-cover', 1440, 565, true);
}
add_action( 'after_setup_theme', 'cr_image_sizes' );
