<?php

namespace CNET\Bridge;

class Post_Manager {
    public function parse_post($post) {
        $parsed_blocks = parse_blocks($post);

        $filter_empty_blocks = array_filter($parsed_blocks, fn ($item) => $item['blockName'] !== NULL);

        $filtered_array = array_values($filter_empty_blocks);

		$blocks = apply_filters('bridge_block_filter', $filtered_array);

		return $this->build_html($blocks);

    }

	private function build_html($blocks) {
		$html = '';

		foreach ($blocks as $block) {
			if ($block['blockName'] !== 'parsed') continue;

			$html .= $block['block_html'];
		}

		return $html;
	}
}
