<?php
namespace CNET\Bridge;

use WP_Error;

Class Query_Manager {
    private static Query_Manager $_instance;

    private Post_Manager $post_manager;

    public function __construct() {
        $this->post_manager = new Post_Manager;
    }

    public function get_post_by_id($id) {
        $post = get_post($id);

        if (empty($post)) {
            return new WP_Error('no_post', 'Invalid post id', ['status' => 404]);
        }

        if (!has_blocks($post->post_content)){
            return $post;
        }

        return $this->post_manager->build_html($post->post_content);
    }
}
