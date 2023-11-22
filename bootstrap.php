<?php

/*
 * Plugin Name: Parse blocks
 */

namespace Cnet\ParseBlocks;


class ParseBlocksManager {
	private static $_instance = null;

	protected function __construct() {
		RestfulManager::bootstrap();
	}

	public static function init() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self;
		}
	}
}

require_once __DIR__ . '/autoloader.php';

add_action('init', __NAMESPACE__ . '\ParseBlocksManager::init');