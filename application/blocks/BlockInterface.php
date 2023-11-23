<?php

namespace CNET\Bridge\Blocks;

interface BlockInterface
{
    function init();
    function parse($content);
}
