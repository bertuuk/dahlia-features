<?php
/**
 * Plugin Name: Dahlia Features
 * Description: A plugin for custom features in the Dahlia theme.
 * Version: 1.0.0
 * Author: Bertuuk
 */

defined( 'ABSPATH' ) || exit;

// Define plugin constants
define('DAHLIA_FEATURES_VERSION', '1.0.0');
define('DAHLIA_FEATURES_PATH', plugin_dir_path(__FILE__));
define('DAHLIA_FEATURES_URL', plugin_dir_url(__FILE__));

require_once DAHLIA_FEATURES_PATH . 'includes/admin-scripts.php';
require_once DAHLIA_FEATURES_PATH . 'includes/categories-extended-icon.php';
require_once DAHLIA_FEATURES_PATH . 'includes/categories-extended-image.php';