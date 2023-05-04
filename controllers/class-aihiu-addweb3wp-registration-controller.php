<?php

// Prevent direct access to this file.
if (!defined('ABSPATH')) {
    exit;
}

class AIHIU_AddWeb3WP_Registration_Controller {

    public function __construct() {
        // Attach the 'aihiu_addweb3wp_login_register' function to the 'init' action hook
        add_action('init', array($this, 'aihiu_addweb3wp_login_register'));
    
        // Add AJAX action hooks
        add_action('wp_ajax_nopriv_aihiu_addweb3wp_login_register', array($this, 'aihiu_addweb3wp_ajax_login_register'));
        add_action('wp_ajax_aihiu_addweb3wp_login_register', array($this, 'aihiu_addweb3wp_ajax_login_register'));
    }
    
    // Function to handle the login and registration process for users with Web3 wallets
    public function aihiu_addweb3wp_ajax_login_register() {
        // Sanitize and get the wallet address from the POST data
        $wallet_address = sanitize_text_field($_POST['walletAddress']);
    
        // Call the existing function to handle login and registration
        $result = $this->aihiu_addweb3wp_login_register($wallet_address);
    
        // Send a JSON response
        if ($result) {
            wp_send_json_success(array('message' => 'Logged in/registered successfully.'));
        } else {
            wp_send_json_error(array('message' => 'Error logging in/registering.'));
        }
    }
    

    // Function to handle the login and registration process for users with Web3 wallets
    public function aihiu_addweb3wp_login_register($wallet_address = null) {
        // Check if the Web3 wallet login/register request is sent
        if (isset($_POST['aihiu_addweb3wp_login_register_nonce']) && wp_verify_nonce($_POST['aihiu_addweb3wp_login_register_nonce'], 'aihiu_addweb3wp_login_register_action')) {
            // Sanitize and get the wallet address
            $wallet_address = sanitize_text_field($_POST['aihiu_addweb3wp_wallet_address']);
        }

        if ($wallet_address !== null) {
            // Search for an existing user with the same wallet address
            $user_query = new WP_User_Query(array(
                'meta_key' => 'aihiu_addweb3wp_wallet_address',
                'meta_value' => $wallet_address,
                'number' => 1,
            ));

            $users = $user_query->get_results();

            // If an existing user is found, log them in
            if (!empty($users)) {
                $user = $users[0];
                wp_set_auth_cookie($user->ID);
                wp_redirect(home_url());
                exit;
            } else {
                // If no existing user is found, create a new user
                $random_password = wp_generate_password();
                $user_id = wp_create_user($wallet_address, $random_password);

                if (!is_wp_error($user_id)) {
                    // Save the wallet address to the user meta
                    update_user_meta($user_id, 'aihiu_addweb3wp_wallet_address', $wallet_address);

                    // Log the new user in
                    wp_set_auth_cookie($user_id);

                    // Redirect the new user to the home page
                    wp_redirect(home_url());
                    exit;
                } else {
                    // If there was an error creating the user, display the error message
                    wp_die($user_id->get_error_message());
                }
            }
        }
    }


// Instantiate the controller
$aihiu_addweb3wp_registration_controller = new AIHIU_AddWeb3WP_Registration_Controller();
