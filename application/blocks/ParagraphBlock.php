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
        $this->filterBlocks('core/paragraph');
        $parsed = $this->toHTML();
        print_r($parsed);die();
		return $content;
	}

    function toHTML()
    {
        foreach ($this->filtered_array as $key => $block)
        {
            $this->blocks[$key] = $block['innerHTML'];
        }
        return $this->blocks;
    }
}
