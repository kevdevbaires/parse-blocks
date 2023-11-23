<?php

namespace CNET\Bridge\Blocks;

class ParagraphBlock extends BlockParser implements BlockInterface {
	public function __construct() {
        add_action('init',function () {
            $this->init();
        });
	}

    public function init()
    {
        add_filter('bridge_block_filter', [$this, 'parse']);
    }
	public function parse($content) {
        $this->blocks = $content;
        $filteredBlocks = $this->filterBlocks('core/paragraph');
        return $this->toHTML($filteredBlocks);
	}

    protected function toHTML($filteredBlocks)
    {
        foreach ($filteredBlocks as $key => $block) {
            $this->blocks[$key] = $block['innerHTML'];
        }

        return $this->blocks;
    }
}
