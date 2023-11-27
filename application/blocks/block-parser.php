<?php

namespace CNET\Bridge\Blocks;

use DOMDocument;
class Block_Parser {
    protected $blocks;

    protected function filter_by_block_name($blockName) {
        return array_filter($this->blocks, function ($item) use ($blockName) {
            return $item['blockName'] == $blockName;
        });
    }

	public function parse_inner_html($block) {
		$doc = new DOMDocument();
		libxml_use_internal_errors(true);

		if ($doc->loadHTML($block['innerHTML'])){
		    return $doc;
		}

		return $doc->loadHTML($block['innerHTML']);
	}
}
