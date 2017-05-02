<?php

namespace Ekkinox\KataSpiral\Model;

use Ekkinox\KataSpiral\Factory\SlotFactory;
use InvalidArgumentException;

/**
 * @package Ekkinox\KataSpiral\Model
 */
class Board implements DrawableInterface
{
    /**
     * @var SlotFactory
     */
    private $slotFactory;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var Slot[][]
     */
    private $slotsMap;

    /**
     * @param SlotFactory $slotFactory
     * @param int         $width
     * @param int         $height
     */
   public function __construct(SlotFactory $slotFactory, int $width, int $height)
   {
       $this->slotFactory = $slotFactory;
       $this->width       = $width;
       $this->height      = $height;

       $this->initSlotsMap();
   }

    /**
     * @@inheritdoc
     */
   public function getDrawing(): string
   {
       $drawing = '';

       foreach ($this->slotsMap as $slotsRow) {

           foreach ($slotsRow as $slot) {
               $drawing .= $slot->getDrawing();
           }

           $drawing .= PHP_EOL;
       }

       return $drawing;
   }

    /**
     * @param int $x
     * @param int $y
     *
     * @return Board
     */
   public function useSlot(int $x, int $y): self
   {
        if ($this->validatePosition($x, $y)) {
            ($this->slotsMap[$x][$y])->setUsed(true);
        }

        return $this;
   }

    /**
     * @return Board
     */
   private function initSlotsMap(): self
   {
       $this->slotsMap = [];

       for ($x = 0; $x < $this->width; $x++) {

           $this->slotsMap[$x] = [];

           for ($y = 0; $y < $this->height; $y++) {

               $slot = $this->slotFactory->create();
               $this->slotsMap[$x][$y] = $slot->setX($x)->setY($y);

           }
       }

       return $this;
   }

    /**
     * @param int $x
     * @param int $y
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
   private function validatePosition(int $x, int $y): bool
   {
       if ($x > $this->width - 1) {
           throw new InvalidArgumentException(
               sprintf('X position %s is out of bounds (0 < x < %s)', $x, $this->width -1)
           );
       }

       if ($y > $this->height - 1) {
           throw new InvalidArgumentException(
               sprintf('Y position %s is out of bounds (0 < y < %s)', $y, $this->height -1)
           );
       }

       return true;
   }
}
