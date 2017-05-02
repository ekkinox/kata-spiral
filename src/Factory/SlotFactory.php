<?php

namespace Ekkinox\KataSpiral\Factory;

use Ekkinox\KataSpiral\Model\Slot;

/**
 * @package Ekkinox\KataSpiral\Factory
 */
class SlotFactory
{
    /**
     * @return Slot
     */
    public function create(): Slot
    {
        return new Slot();
    }
}
