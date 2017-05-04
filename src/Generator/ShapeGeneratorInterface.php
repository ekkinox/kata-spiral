<?php

namespace Ekkinox\KataSpiral\Generator;

use Ekkinox\KataSpiral\Model\Board;

/**
 * @package Ekkinox\KataSpiral\Generator
 */
interface ShapeGeneratorInterface
{
    /**
     * @return Board
     */
    public function generate(): Board;
}
