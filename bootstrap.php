<?php

/*
 * Plugin Name: Parse blocks
 */

namespace CNET\Bridge;

class CNetBridge {

    /**
     * Single instance of itself
     *
     * @var CNetBridge
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
	protected function __construct()
    {
		RestfulManager::bootstrap();
	}

    /**
     * Activation hook
     *
     * @return void
     *
     * @access public
     */
	public static function init()
    {
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
    public static function activate()
    {
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
    add_action('init', __NAMESPACE__ . '\CNetBridge::init');

    register_activation_hook(__FILE__, __NAMESPACE__ . '\CNetBridge::activate');
}