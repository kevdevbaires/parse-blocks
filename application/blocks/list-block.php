<?php

namespace CNET\Bridge\Blocks;

class List_Block extends Block_Parser implements Block_Interface {

	const BLOCK_NAME = 'core/list';

	public function __construct() {
		add_action('init',function () {
			$this->init();
		});
	}

	public function init() {
		add_filter('bridge_block_filter', [$this, 'block_parser']);
	}

	public function block_parser($content) {
		$this->blocks = $content;

		$filteredBlocks = $this->filter_by_block_name(self::BLOCK_NAME);

		return $this->to_html($filteredBlocks);
	}

	public function to_html($filteredBlocks) {
		foreach ($filteredBlocks as $key => $block) {
			$this->blocks[$key] = [
				'blockName' => 'parse',
				'block_html' => $this->get_attributes($block)
			];
		}

		return $this->blocks;
	}

	private function get_attributes($block) {
		$inner_html = $this->parse_inner_html($block);

		if (!$inner_html) return null;

		return $this->loop_inner_blocks($block);
	}

	private function loop_inner_blocks($block){
		if (!is_array($block) || count($block) == 0) return '';

		$list_items = [];

		$opening_tag = reset($block['innerContent']);
		$closing_tag = end($block['innerContent']);

		if (is_array($block['innerBlocks']) || count($block['innerBlocks']) > 0){
			foreach($block['innerBlocks'] as $key => $list_item_block) {

				if(count($list_item_block['innerBlocks']) > 0) {
					$this->loop_inner_blocks($list_item_block);
				}

				$list_items[$key] = trim(preg_replace('/\s+/', ' ', $list_item_block['innerHTML']));
			}
		}

		return $opening_tag . implode($list_items) . $closing_tag;
	}
}
