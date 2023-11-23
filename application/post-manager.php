<?php

namespace CNET\Bridge;

class Post_Manager {
    public function parse_post($post) {
        $parsed_blocks = parse_blocks($post);

        $filter_empty_blocks = array_filter($parsed_blocks, fn ($item) => $item['blockName'] !== NULL);

        $filtered_array = array_values($filter_empty_blocks);

        return apply_filters('bridge_block_filter', $filtered_array);
    }
}
