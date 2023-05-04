<?php

// Prevent direct access to this file.
if (!defined('ABSPATH')) {
    exit;
}

class AIHIU_AddWeb3WP_User {

    // Function to get the Web3 wallet address associated with a user
    public static function get_wallet_address($user_id) {
        $wallet_address = get_user_meta($user_id, 'aihiu_addweb3wp_wallet_address', true);
        return $wallet_address;
    }

    // Function to set the Web3 wallet address for a user
    public static function set_wallet_address($user_id, $wallet_address) {
        update_user_meta($user_id, 'aihiu_addweb3wp_wallet_address', $wallet_address);
    }

    // Function to check if a user has a Web3 wallet connected
    public static function has_wallet_address($user_id) {
        $wallet_address = self::get_wallet_address($user_id);
        return !empty($wallet_address);
    }
}
