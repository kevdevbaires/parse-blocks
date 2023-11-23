<?php

namespace CNET\Bridge\Blocks;

interface Block_Interface {
    function init();

    function block_parser($content);

    function to_html($filteredBlocks);
}
