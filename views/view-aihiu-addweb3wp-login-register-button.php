<?php

// Prevent direct access to this file.
if (!defined('ABSPATH')) {
    exit;
}

// Function to display the "Connect Web3 Wallet" button and handle the associated shortcode
function aihiu_addweb3wp_connect_button_shortcode() {
    ob_start();
    ?>
    <div class="aihiu-addweb3wp-connect-button">
        <button id="aihiu-addweb3wp-connect-button" class="button">
            Connect Web3 Wallet
        </button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('aihiu_addweb3wp_connect_button', 'aihiu_addweb3wp_connect_button_shortcode');
