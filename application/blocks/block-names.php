<?php
namespace CNET\Bridge\Blocks;

enum Block_Names {
    case PARAGRAPH;
    case B;

    public function do() {
        return match ($this) {
            static::PARAGRAPH  => 'core/paragraph',
            static::B  => 'Doing B',
        };
    }
}
