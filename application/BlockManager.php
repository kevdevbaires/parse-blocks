<?php

namespace Cnet\ParseBlocks;

class BlockManager {
	public $blocks;

	function parseBlocks($blocks, $name) {
		// filtrar $blocks para que devuelva solomaente los bloques del parametro $name
		// $name = core/paragraph

		$blocks = array_fillter($blocks, function ($block) use ($name){
			return $block['blockName'] == $name;
		});

		return true;
	}
}