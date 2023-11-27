<?php

namespace CNET\Bridge\Blocks;

class Image_Block extends Block_Parser implements Block_Interface {

    public function __construct() {
        add_action('init',function () {
            $this->init();
        });
    }

    public function init() {
        add_filter('bridge_block_filter', [$this, 'block_parser']);
    }

    public function block_parser($content) {
        $this->blocks = $content;

        $filteredBlocks = $this->filter_by_block_name('core/image');

        return $this->to_html($filteredBlocks);
    }

    public function to_html($filteredBlocks) {
        foreach ($filteredBlocks as $key => $block) {
			$attributes = $this->get_attributes($block);

			if (is_null($attributes)) continue;

			$this->blocks[$key] = [
				'blockName' => 'parsed',
				'block_html' => $attributes ?
					'<div data-shortcode="image" data-float="'. $attributes['float'] .'" data-image-caption="' . $attributes['caption'] . '" data-image-alt-text="'. $attributes['alt'] .'" data-image-target-url="'. $attributes['target_url'] .'" data-image-file-name="'. $attributes['basename'] .'" data-image-date-created="' . $attributes['upload_date'] . '"></div>'
					: ''
			];
        }

        return $this->blocks;
    }

	public function get_attributes($block) {
		$inner_html = $this->parse_inner_html($block);

		if (!$inner_html) return null;

		$image_tag = $inner_html->getElementsByTagName('img');

		if (empty($image_tag[0]->getAttribute('src'))){
		    return false;
		}else {
			$image_tag = $image_tag[0];
		}

		$src = $image_tag->getAttribute('src');
		$alt = $image_tag->getAttribute('alt');

		$image_path = pathinfo($src);
		$image_extension = pathinfo(parse_url($src)['path'], PATHINFO_EXTENSION);

		$filename = empty($image_extension) ? $image_path['basename'] : $image_path['filename'] . '.' . $image_extension;

		$upload_date = $this->get_upload_date($image_path['dirname'], $image_path['filename']);

		$caption = $inner_html->getElementsByTagName('figcaption');
		$caption = $caption[0] ? "<p>{$caption[0]->textContent}</p>" : '<p></p>';

		$float = $block['attrs']['align'] ?? 'left';

		if (isset($block['attrs']['linkDestination']) && $block['attrs']['linkDestination'] == 'custom'){
			$anchor_tag = $inner_html->getElementsByTagName('a');
			$link = $anchor_tag[0]->getAttribute('href');
		}

		return [
			'src'         => $src,
			'alt'         => $alt,
			'target_url'  => $link ?? '',
			'basename'    => rawurlencode( $filename ),
			'caption'     => $caption,
			'upload_date' => $upload_date ?? '',
			'float'       => $float,
		];

	}

	private function get_upload_date($dirname, $name) {

		if (str_contains($dirname, get_bloginfo('url'))){
			$post = get_posts([
				'post_type' => 'attachment',
				'post_name' => sanitize_title($name),
				'posts_per_page' => 1,
				'post_status' => 'inherit'
			]);

			return date("Y/m/d", strtotime($post[0]->post_date));
		}

		return null;
	}
}
