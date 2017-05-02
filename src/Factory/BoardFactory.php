<?php

namespace Ekkinox\KataSpiral\Factory;

use Ekkinox\KataSpiral\Model\Board;

/**
 * @package Ekkinox\KataSpiral\Factory
 */
class BoardFactory
{
    /**
     * @param SlotFactory $slotFactory
     * @param int         $width
     * @param int         $height
     *
     * @return Board
     */
    public function create(SlotFactory $slotFactory, int $width, int $height): Board
    {
        return new Board($slotFactory, $width, $height);
    }
}
