<?php

namespace CNET\Bridge\Blocks;

class Block_Parser {
    protected $blocks;

    protected function filter_by_block_name($blockName) {
        return array_filter($this->blocks, function ($item) use ($blockName) {
            return $item['blockName'] == $blockName;
        });
    }
}
