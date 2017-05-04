<?php

namespace Ekkinox\KataSpiral\Factory;

use Ekkinox\KataSpiral\Generator\SpiralGenerator;

/**
 * @package Ekkinox\KataSpiral\Factory
 */
class SpiralGeneratorFactory
{
    /**
     * @param BoardFactory $boardFactory
     * @param SlotFactory  $slotFactory
     * @param int          $width
     * @param int          $height
     * @param string       $way
     *
     * @return SpiralGenerator
     */
    public function create(
        BoardFactory $boardFactory,
        SlotFactory $slotFactory,
        int $width,
        int $height,
        string $way = SpiralGenerator::WAY_CLOCKWISE
    ): SpiralGenerator
    {
        return new SpiralGenerator($boardFactory, $slotFactory, $width, $height, $way);
    }
}
