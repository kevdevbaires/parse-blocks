<?php
namespace Cnet\ParseBlocks;

use WP_Error;

Class QueryManager {

	public function __construct() {
	}


	public static function getPost($id) {
		$post = get_post($id);

		if (empty($post)) {
			return new WP_Error('no_post', 'Invalid post id', ['status' => 404]);
		}

		if (!has_blocks($post->post_content)){
			return $post;
		}

		$parsed_blocks = parse_blocks($post->post_content);

		$filterArray = array_filter($parsed_blocks, fn ($item) => $item['blockName'] !== NULL);

		// Reset array keys if needed
		$resultArray = array_values($filterArray);

		/*
		 * Call to custom filter in blocks/ParagraphBlock.php file
		 * */
		$rendered_content = apply_filters('my_custom_filter_hook', $resultArray);

		/*
		 * Debug to check if it's entering the custom filter
		 * */
		var_dump($rendered_content);
		die();

		return $rendered_content;
	}
}


/*
 * Testing filter, if you call this one, it works.
 * */
add_filter('parse_block', function($block) {
	return 'entro parse_block filter';
});


