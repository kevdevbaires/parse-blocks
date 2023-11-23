<?php

namespace CNET\Bridge\Blocks;

class BlockParser
{
    protected $blocks;

    protected function filterBlocks($blockName)
    {
        return array_filter($this->blocks, function ($item) use ($blockName) {
            return $item['blockName'] == $blockName;
        });
    }
}
