<?php

namespace CNET\Bridge\Blocks;

interface Block_Interface {
    function init();

    function get_content($content);
}
