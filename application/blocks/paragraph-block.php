<?php

namespace CNET\Bridge\Blocks;

class Paragraph_Block extends Block_Parser implements Block_Interface {

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

        $filteredBlocks = $this->filter_by_block_name('core/paragraph');

        return $this->to_html($filteredBlocks);
	}

    public function to_html($filteredBlocks) {
        foreach ($filteredBlocks as $key => $block) {
            $this->blocks[$key] = trim(preg_replace('/\s+/', ' ', $block['innerHTML']));
        }

        return $this->blocks;
    }
}
