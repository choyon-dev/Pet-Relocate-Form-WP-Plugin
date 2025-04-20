<?php
/**
 * Plugin Name:       Paws Relocate
 * Plugin URI:        #
 * Description:       A multi-step form for collecting pet relocation details and managing submissions.
 * Version:           1.0.0
 * Author:            Choyon
 * Author URI:        https://github.com/choyon-dev
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       paws-relocate
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
define( 'PR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PR_VERSION', '1.0.0' );
define( 'PR_TABLE_NAME', 'paws_relocate_submissions' );

// Include necessary files
require_once PR_PLUGIN_PATH . 'includes/activation.php';
require_once PR_PLUGIN_PATH . 'includes/shortcode.php';
require_once PR_PLUGIN_PATH . 'includes/ajax-handler.php';
require_once PR_PLUGIN_PATH . 'includes/admin-page.php';
require_once PR_PLUGIN_PATH . 'includes/email.php';

register_activation_hook( __FILE__, 'pr_activate_plugin' );


function pr_enqueue_scripts() {
    global $post;
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'paws_relocate_form' ) ) {

        wp_enqueue_style(
            'pr-styles',
            PR_PLUGIN_URL . 'assets/css/plugin-styles.css',
            array(),
            PR_VERSION
        );

        wp_enqueue_script(
            'pr-scripts',
            PR_PLUGIN_URL . 'assets/js/plugin-scripts.js',
            array( 'jquery' ), 
            PR_VERSION,
            true
        );

        wp_localize_script( 'pr-scripts', 'pr_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'pr_form_nonce' ), 
            'loading_message' => __( 'Submitting...', 'paws-relocate' ),
            'error_message' => __( 'An error occurred. Please try again.', 'paws-relocate' ),
            'validation_message' => __( 'Please fill in all required fields marked with * before proceeding.', 'paws-relocate'),
            'server_error_message' => __( 'Could not process request. Please check console or contact admin.', 'paws-relocate'),
            'success_message' => __( 'Form submitted successfully! Thank you.', 'paws-relocate' )
        ));
    }
}
add_action( 'wp_enqueue_scripts', 'pr_enqueue_scripts' );

function pr_admin_enqueue_scripts($hook) {
    if ( 'toplevel_page_paws-relocate-submissions' !== $hook ) {
        return;
    }
}
add_action( 'admin_enqueue_scripts', 'pr_admin_enqueue_scripts' );
add_shortcode( 'paws_relocate_form', 'pr_render_form_shortcode' );
add_action( 'wp_ajax_pr_submit_form', 'pr_handle_ajax_submission' ); 
add_action( 'wp_ajax_nopriv_pr_submit_form', 'pr_handle_ajax_submission' ); 
add_action( 'admin_menu', 'pr_add_admin_menu_page' ); ?>