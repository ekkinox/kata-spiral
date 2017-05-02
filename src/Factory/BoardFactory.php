<?php

namespace Ekkinox\KataSpiral\Factory;

use Ekkinox\KataSpiral\Model\Board;

/**
 * @package Ekkinox\KataSpiral\Factory
 */
class BoardFactory
{
    /**
     * @param int $width
     * @param int $height
     *
     * @return Board
     */
    public function create(int $width, int $height): Board
    {
        return new Board($width, $height);
    }
}
