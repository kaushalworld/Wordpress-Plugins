<?php

/*
Plugin Name: WP Reactions Pro
Description: The #1 Emoji Reactions Plugin for WordPress. Engage your users with Lottie animated emoji reactions and increase social sharing with mobile and desktop sharing pop-ups and surprise button reveals. Put your emojis anywhere you want to get a reaction.
Plugin URI: https://wpreactions.com
Version: 3.0.30
Author: WP Reactions, LLC
Author URI: https://wpreactions.com
License: GPL2
Text Domain: wpreactions
*/

use WPRA\App;

define('WPRA_VERSION', '3.0.30');
define('WPRA_DB_VERSION', 1);
define('WPRA_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WPRA_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WPRA_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('WPRA_SITE_URL', get_site_url());

spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'WPRA\\') === false) return;
    $file      = str_replace('WPRA\\', '', $class_name);
    $file      = str_replace('\\', '/', $file);
    $file_path = WPRA_PLUGIN_PATH . 'includes/' . $file;

    if (file_exists($file_path . '.class.php')) {
        require_once($file_path . '.class.php');
    } else if (file_exists($file_path . '.int.php')) {
        require_once($file_path . '.int.php');
    }

});

function wpreactions() {
    return App::instance();
}

wpreactions();