<?php

// Prevent direct access to this file.
if (!defined('ABSPATH')) {
    exit;
}

// Main plugin class.
class Aihiu_AddWeb3_WordPress
{
    // Constructor function to initialize the class.
    public function __construct()
    {
        // Register hooks.
        $this->register_hooks();
    }

    // Register hooks function.
    public function register_hooks()
    {
        // Register activation hook.
        register_activation_hook(__FILE__, array($this, 'activate'));
        
        // Register deactivation hook.
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        
        // Add action hook for loading assets.
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));
        
        // Add action hook for initializing the plugin.
        add_action('init', array($this, 'initialize_plugin'));
        
        // Add action hook for displaying admin notices.
        add_action('admin_notices', array($this, 'display_admin_notices'));
    
        //hooks to add the "Connect Web3 Wallet" button to the user's profile page 
        add_action('show_user_profile', array($this, 'add_web3_wallet_button'));
        add_action('edit_user_profile', array($this, 'add_web3_wallet_button'));

        // Enqueue Ethers.js library
        wp_enqueue_script('ethers', 'https://cdn.ethers.io/lib/ethers-5.4.6.min.js', array(), '5.4.6', true);

        //save web3 wallet
        add_action('wp_ajax_aihiu_addweb3_save_wallet_address', array($this, 'save_web3_wallet_address'));
    
    }

    // Function to load assets.
    public function load_assets() 
    {
        // Enqueue front-end CSS
        wp_enqueue_style('aihiu-addweb3-wordpress-frontend', plugin_dir_url(__FILE__) . 'assets/css/frontend.css');
    
        // Enqueue front-end JS
        wp_enqueue_script('aihiu-addweb3-wordpress-frontend', plugin_dir_url(__FILE__) . 'assets/js/frontend.js', array('jquery'), '1.0.0', true);
    
        // Enqueue web3 wallet connection JS
        wp_enqueue_script('aihiu-addweb3-wordpress-web3-connection', plugin_dir_url(__FILE__) . 'assets/js/web3-connection.js', array('jquery'), '1.0.0', true);
    }
    

    // Function to initialize the plugin.
    public function initialize_plugin()
    {
        // Code to initialize the plugin.
    }

    // Activation function.
    public function activate()
    {
        // Check if the installation is multisite.
        if (is_multisite()) {
            $registration_enabled = get_site_option('registration');
            
            // Update site option if user registration is not enabled.
            if ($registration_enabled !== 'user' && $registration_enabled !== 'all') {
                update_site_option('aihiu_addweb3w_user_registration_disabled', true);
            }
        } else {
            $users_can_register = get_option('users_can_register');
            
            // Update option if user registration is not enabled.
            if (!$users_can_register) {
                update_option('aihiu_addweb3w_user_registration_disabled', true);
            }
        }
    }

    // Deactivation function.
    public function deactivate()
    {
        // Code for plugin deactivation.
    }

    // Function to display admin notices.
    public function display_admin_notices()
    {
        // Check if the installation is multisite.
        if (is_multisite()) {
            $user_registration_disabled = get_site_option('aihiu_addweb3w_user_registration_disabled');
        } else {
            $user_registration_disabled = get_option('aihiu_addweb3w_user_registration_disabled');
        }

        // Display error message if user registration is not enabled.
        if ($user_registration_disabled) {
            $class = 'notice notice-error';
            $message = __('AiHiU AddWeb3 Wordpress plugin requires user registration to be enabled.', 'aihiu-addweb3-wordpress');
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
        }
    }

    //function to add the "Connect Web3 Wallet" button to the user's profile page
    public function add_web3_wallet_button($user) 
    {
        ?>
        <h2><?php _e('Web3 Wallet', 'aihiu-addweb3-wordpress'); ?></h2>
        <table class="form-table">
            <tr>
                <th><label for="web3_wallet_address"><?php _e('Wallet Address', 'aihiu-addweb3-wordpress'); ?></label></th>
                <td>
                    <input type="text" name="web3_wallet_address" id="web3_wallet_address" value="<?php echo esc_attr(get_user_meta($user->ID, 'web3_wallet_address', true)); ?>" class="regular-text" readonly>
                    <br>
                    <input type="button" name="connect_web3_wallet" id="connect_web3_wallet" class="button button-secondary" value="<?php _e('Connect Web3 Wallet', 'aihiu-addweb3-wordpress'); ?>">
                </td>
            </tr>
        </table>
        <?php
    }
    
}

// Instantiate the main plugin class.
$aihiu_addweb3_wordpress = new Aihiu_AddWeb3_WordPress();
