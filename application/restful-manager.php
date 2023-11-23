<?php
namespace CNET\Bridge;

use WP_REST_Response;

class Restful_Manager {
	private static $_instance = null;
    private Query_Manager $query_manager;
	const ROUTE_NAMESPACE = 'bridge/v1';

    protected function __construct() {
        $this->query_manager = new Query_Manager;

		add_action('rest_api_init', function () {
			register_rest_route(self::ROUTE_NAMESPACE, '/post/(?P<id>\d+)', [
				'methods' => 'GET',
				'callback' => [$this, 'fetch_post_by_id'],
				'arg' => [
					'id' => [
						'required' => true,
						'validate_callback' => function($param) {
							return is_numeric($param);
						}
					]
				]
			]);

			register_rest_route(self::ROUTE_NAMESPACE, '/posts', [
				'methods' => 'GET',
				'callback' => [$this, 'fetch_posts'],
			]);
		});
	}

	public function fetch_post_by_id($request) {
		$id = $request->get_param('id');

		if (!is_numeric($id) || $id <= 0) {
			return new WP_REST_Response("Invalid or missing 'id' parameter.", 400);
		}

		$post = $this->query_manager->get_post_by_id($id);

		if (!$post) {
			return new WP_REST_Response("Post not found", 404);
		}
		
		return $post;
	}

    public function fetch_posts() {

    }

    /**
     * Bootstrap the core manager
     *
     * @return Restful_Manager
     *
     * @access public
     * @static
     */
    public static function bootstrap() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

}