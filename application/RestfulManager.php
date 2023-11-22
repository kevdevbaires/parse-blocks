<?php
namespace Cnet\ParseBlocks;

use WP_REST_Response;

class RestfulManager {
	private static $_instance = null;
	protected function __construct() {
		/*
		 * Register API routes
		 * */
		add_action('rest_api_init', function () {
			register_rest_route( 'parse-blocks/v1', '/post/(?P<id>\d+)', [
				'methods' => 'GET',
				'callback' => [$this, 'fetchPostById'],
				'arg' => [
					'id' => [
						'required' => true,
						'validate_callback' => function($param, $request, $key) {
							return is_numeric($param);
						}
					]
				]
			]);
		});

		add_action('rest_api_init', function () {
			register_rest_route( 'parse-blocks/v1', '/posts', [
				'methods' => 'GET',
				'callback' => [$this, 'fetchPosts'],
			]);
		});
	}

	public function fetchPostById($request) {
		$id = $request->get_param('id');

		if (!is_numeric($id) || $id <= 0) {
			return new WP_REST_Response("Invalid or missing 'id' parameter.", 400);
		}

		$post = QueryManager::getPost($id);

		if (!$post) {
			return new WP_REST_Response("Post not found", 404);
		}

		$paragraph = new ParagraphBlock;

		return $post;
	}

	public static function bootstrap() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

}