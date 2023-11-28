<?php

namespace CNET\Bridge\Blocks;

class Paragraph_Block extends Block_Parser implements Block_Interface {

    const BLOCK_NAME = 'core/paragraph';

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
                'blockName' => 'parsed',
                'block_html' => $this->get_attributes($block)
            ];
        }

        return $this->blocks;
    }

    public function get_attributes($block) {
        return trim(preg_replace('/\s+/', ' ', $block['innerHTML']));
    }
}
