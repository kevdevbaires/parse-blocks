<?php

namespace Cnet\ParseBlocks;

class ParagraphBlock {
	private static $_instance;

	public $blocks;
	public $html;

	function __constructor() {
		/*
		 * Custom filter that is not working when you apply filter
		 * */
		add_filter( 'my_custom_filter_hook', function (){
			return 'entro my_custom_filter_hook';
		});
	}

	public function parse($content) {
		/*
		 * Return simple string to see if filter is working
		 * */
		return 'entro parse';
	}

	public static function bootstrap() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}
}