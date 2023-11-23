<?php

/*
 * Plugin Name:       CNET WordPress Bridge
 * Description:       Plugin to retrieve parsed content from posts
 * Version:           1.0.0
 * Requires at least: 5.5.0
 * Requires PHP:      7.0.0
 * Author:            CNET Group
 * Author URI:        https://cnet.com
 * Text Domain:       cnet-wordpress-bridge
 */

namespace CNET\Bridge;

class CNET_Bridge {

    /**
     * Single instance of itself
     *
     * @var CNET_Bridge
     *
     * @access private
     */
	private static $_instance = null;

    /**
     * Constructor
     *
     * @return void
     *
     * @access protected
     */
	protected function __construct() {
		Restful_Manager::bootstrap();
	}

    /**
     * Activation hook
     *
     * @return void
     *
     * @access public
     */
	public static function init() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self;
		}
	}

    /**
     * Activation hook
     *
     * @return void
     *
     * @access public
     */
    public static function activate() {
        global $wp_version;

        //check PHP Version
        if (version_compare(PHP_VERSION, '7.0.0') === -1) {
            exit(__('PHP 7.0.0 or higher is required.'));
        } elseif (version_compare($wp_version, '5.0.0') === -1) {
            exit(__('WP 5.5.0 or higher is required.'));
        }
    }
}

if (defined('ABSPATH')) {
    require_once __DIR__ . '/autoloader.php';
    add_action('init', __NAMESPACE__ . '\CNET_Bridge::init');

    register_activation_hook(__FILE__, __NAMESPACE__ . '\CNET_Bridge::activate');
}