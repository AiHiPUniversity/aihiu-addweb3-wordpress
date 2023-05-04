<?php

// Prevent direct access to this file.
if (!defined('ABSPATH')) {
    exit;
}

class AIHIU_AddWeb3WP_Connection_Controller {

    public function __construct() {
        // Attach the AJAX action hooks for logged-in users
        add_action('wp_ajax_aihiu_addweb3wp_connect_wallet', array($this, 'aihiu_addweb3wp_ajax_connect_wallet'));
        add_action('wp_ajax_aihiu_addweb3wp_disconnect_wallet', array($this, 'aihiu_addweb3wp_ajax_disconnect_wallet'));
    }
    
    public function aihiu_addweb3wp_ajax_connect_wallet() {
        // Check if the user is logged in
        if (is_user_logged_in()) {
            // Get the current user
            $user = wp_get_current_user();
    
            // Get the wallet address from the POST data
            $wallet_address = sanitize_text_field($_POST['walletAddress']);
    
            // Save the wallet address to the user meta
            update_user_meta($user->ID, 'aihiu_addweb3wp_wallet_address', $wallet_address);
    
            // Send a JSON response
            wp_send_json_success(array('message' => 'Wallet connected successfully.'));
        } else {
            wp_send_json_error(array('message' => 'User not logged in.'));
        }
    }
    
    public function aihiu_addweb3wp_ajax_disconnect_wallet() {
        // Check if the user is logged in
        if (is_user_logged_in()) {
            // Get the current user
            $user = wp_get_current_user();
    
            // Delete the wallet address from the user meta
            delete_user_meta($user->ID, 'aihiu_addweb3wp_wallet_address');
    
            // Send a JSON response
            wp_send_json_success(array('message' => 'Wallet disconnected successfully.'));
        } else {
            wp_send_json_error(array('message' => 'User not logged in.'));
        }
    }
    

// Instantiate the controller
$aihiu_addweb3wp_connection_controller = new AIHIU_AddWeb3WP_Connection_Controller();
