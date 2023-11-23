<?php

namespace CNET\Bridge\Blocks;

class BlockParser
{
    protected $blocks;

    protected $filtered_array;

    protected function filterBlocks($name)
    {
        $this->filtered_array = array_filter($this->blocks, fn ($item) => $item['blockName'] == $name);
    }
}