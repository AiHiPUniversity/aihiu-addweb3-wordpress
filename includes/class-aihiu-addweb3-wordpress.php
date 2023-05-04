<?php

// Prevent direct access to this file.
if (!defined('ABSPATH')) {
    exit;
}

class AIHIU_AddWeb3_WordPress {
    // Constructor
    public function __construct() {
        // Load required files
        $this->load_dependencies();

        // Register activation and deactivation hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Initialize the plugin
        $this->init();
    }

    // Load required files
    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'controllers/class-aihiu-addweb3wp-connection-controller.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'controllers/class-aihiu-addweb3wp-registration-controller.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'models/class-aihiu-addweb3wp-user.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'views/view-aihiu-addweb3wp-connect-button.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'views/view-aihiu-addweb3wp-login-register-button.php';
    }

    // Initialize the plugin
    public function init() {
        new AIHIU_AddWeb3WP_Connection_Controller();
        new AIHIU_AddWeb3WP_Registration_Controller();

        // Enqueue the JavaScript files
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    // Enqueue the JavaScript files
    public function enqueue_scripts() {
        wp_enqueue_script('aihiu-addweb3wp-connection-controller', plugin_dir_url(dirname(__FILE__)) . 'assets/js/aihiu-addweb3wp-connection-controller.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('aihiu-addweb3wp-registration-controller', plugin_dir_url(dirname(__FILE__)) . 'assets/js/aihiu-addweb3wp-registration-controller.js', array('jquery'), '1.0.0', true);
    }

    // Activation function
    public function activate() {
        // TODO: Add any activation logic here
    }

    // Deactivation function
    public function deactivate() {
        // TODO: Add any deactivation logic here
    }
}

// Instantiate the plugin
$aihiu_addweb3_wordpress_plugin = new AIHIU_AddWeb3_WordPress();
