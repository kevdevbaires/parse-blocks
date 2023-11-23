<?php
namespace CNET\Bridge;

use CNET\Bridge\Blocks\ParagraphBlock;
use WP_Error;

Class QueryManager {
    private static QueryManager $_instance;

    public function getPost($id)
    {
		$post = get_post($id);

		if (empty($post)) {
			return new WP_Error('no_post', 'Invalid post id', ['status' => 404]);
		}

		if (!has_blocks($post->post_content)){
			return $post;
		}

        return $this->parsePost($post->post_content);

	}

    protected function parsePost($post)
    {
        $parsed_blocks = parse_blocks($post);

        $filter_empty_blocks = array_filter($parsed_blocks, fn ($item) => $item['blockName'] !== NULL);

        $filtered_array = array_values($filter_empty_blocks);

        return apply_filters('bridge_block_filter', $filtered_array);
    }
}
