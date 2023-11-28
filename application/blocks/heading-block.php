<?php

namespace CNET\Bridge\Blocks;

class Heading_Block extends Block_Parser implements Block_Interface {

	public function __construct() {
		add_action('init',function () {
			$this->init();
		});
	}

	function init() {
		add_filter('bridge_block_filter', [$this, 'block_parser']);
	}

	function block_parser( $content ) {
		$this->blocks = $content;

		$filteredBlocks = $this->filter_by_block_name('core/heading');

		return $this->to_html($filteredBlocks);
	}

	function to_html( $filteredBlocks ) {
		foreach ($filteredBlocks as $key => $block) {
			$this->blocks[$key] = [
				'blockName' => 'parsed',
				'block_html' => $this->get_attributes($block)
			];
		}

		return $this->blocks;
	}

	function get_attributes($block) {
		$inner_html = $this->parse_inner_html($block);

		if (!$inner_html) return null;

		$heading_tag = 'h2';

		if (isset($block['attrs']['level'])){
		    $heading_tag = 'h' . (string) $block['attrs']['level'];
		}

		$heading = $inner_html->getElementsByTagName($heading_tag);

		if (empty($heading[0])){
			return false;
		}else {
			$heading = $heading[0];
		}

		return "<{$heading_tag}>{$heading->textContent}</{$heading_tag}>";

	}
}