<?php
/**
 * Plugin Name: AiHiPU AddWeb3 To Wordpress
 * Plugin URI: https://AiHiPUniversity.com 
 * Description: A plugin to turn your wordpres to dApp by connecting to web3 features like wallet, FT/NTF content lock and lot more extended to web3 protocols with addons.
 * Version: 1.0.0
 * Author: Solomon Foskaay
 * Author URI: https://AiHiPUniversity.com 
 */

// Prevent direct access to this file.
if (!defined('ABSPATH')) {
    exit;
}

// Require the main plugin class file.
require_once plugin_dir_path(__FILE__) . 'includes/class-aihiu-addweb3-wordpress.php';

// Instantiate the main plugin class.
$aihiu_addweb3_wordpress = new Aihiu_AddWeb3_WordPress();
