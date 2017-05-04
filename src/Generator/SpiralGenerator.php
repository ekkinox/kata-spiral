<?php

namespace Ekkinox\KataSpiral\Generator;

use Ekkinox\KataSpiral\Factory\BoardFactory;
use Ekkinox\KataSpiral\Factory\SlotFactory;
use Ekkinox\KataSpiral\Model\Board;
use Ekkinox\KataSpiral\Model\Slot;

/**
 * @package Ekkinox\KataSpiral\Generator
 */
class SpiralGenerator extends AbstractShapeGenerator
{
    /** Directions */
    public const DIRECTION_TOP    = 'top';
    public const DIRECTION_RIGHT  = 'right';
    public const DIRECTION_BOTTOM = 'bottom';
    public const DIRECTION_LEFT   = 'left';

    /** Ways */
    public const WAY_CLOCKWISE     = 'clockwise';
    public const WAY_ANTICLOCKWISE = 'anticlockwise';

    /**
     * @var string
     */
    private $currentWay = self::WAY_CLOCKWISE;

    /**
     * @var string
     */
    private $currentDirection = self::DIRECTION_LEFT;

    /**
     * @var int
     */
    private $currentMove;

    /**
     * @param BoardFactory $boardFactory
     * @param SlotFactory  $slotFactory
     * @param int          $width
     * @param int          $height
     * @param string       $way
     */
    public function __construct(
        BoardFactory $boardFactory,
        SlotFactory $slotFactory,
        int $width = 0,
        int $height = 0,
        string $way = self::WAY_CLOCKWISE
    ) {
        parent::__construct($boardFactory, $slotFactory, $width, $height);

        $this->currentWay       = $way;
        $this->currentMove      = 0;
        $this->currentDirection = $this->currentWay == static::WAY_CLOCKWISE
            ? static::DIRECTION_RIGHT
            : static::DIRECTION_BOTTOM;
    }

    /**
     * @inheritdoc
     */
   public function generate(): Board
   {
       while ($this->canMove()) {
           $this->getCurrentSlot()->setUsed(true);
           $this->move();
       }

       return $this->currentBoard;
   }

    /**
     * @return Slot
     */
   private function getCurrentSlot(): Slot
   {
       return $this->currentBoard->getSlot($this->currentX, $this->currentY);
   }

    /**
     * @return bool
     */
   private function canMove(): bool
   {
       $canMoveX = true;
       $canMoveY = true;

       if ($this->mustTurn()) {
           $this->turn();
       }

       if ($this->isGoingHorizontally()) {
           if ($this->currentX >= 2 && $this->currentX <= $this->currentWidth - 3) {
               $deltaX  = $this->currentDirection == static::DIRECTION_RIGHT ? 2 : -2;
               $canMoveX = $this->currentBoard->getSlot($this->currentX + $deltaX, $this->currentY)->isFree();

           }
       } elseif ($this->isGoingVertically()) {
           if ($this->currentY >= 2 && $this->currentY <= $this->currentHeight - 3) {
               $deltaY  = $this->currentDirection == static::DIRECTION_BOTTOM ? 2 : -2;
               $canMoveY = $this->currentBoard->getSlot($this->currentX, $this->currentY + $deltaY)->isFree();
           }
       }

       if ($this->currentWidth % 2 == 0 && $this->currentHeight % 2 == 0) {
           $maxMoves = (($this->currentWidth * $this->currentHeight) / 2) + max($this->currentWidth,$this->currentHeight) - 2;
           if ($this->currentMove > $maxMoves) {
               return false;
           }
       }

       return $canMoveX && $canMoveY;
   }

    /**
     * @return SpiralGenerator
     */
   private function move(): self
   {
       if ($this->isGoingTo(static::DIRECTION_TOP)) {
           $this->currentY -= 1;
       } elseif ($this->isGoingTo(static::DIRECTION_RIGHT)) {
            $this->currentX += 1;
       } elseif ($this->isGoingTo(static::DIRECTION_BOTTOM)) {
           $this->currentY += 1;
       } elseif ($this->isGoingTo(static::DIRECTION_LEFT)) {
           $this->currentX -= 1;
       }

       $this->currentMove++;

       return $this;
   }

    /**
     * @param string $direction
     *
     * @return bool
     */
   private function isGoingTo(string $direction): bool
   {
       return $this->currentDirection == $direction;
   }

    /**
     * @return bool
     */
    private function isGoingVertically(): bool
    {
        return in_array(
            $this->currentDirection,
            [
                static::DIRECTION_BOTTOM,
                static::DIRECTION_TOP
            ]
        );
    }

    /**
     * @return bool
     */
    private function isGoingHorizontally(): bool
    {
        return in_array(
            $this->currentDirection,
            [
                static::DIRECTION_LEFT,
                static::DIRECTION_RIGHT
            ]
        );
    }

    /**
     * @return bool
     */
    private function mustTurn(): bool
    {
        $canContinue       = false;
        $contiguousSlotOnX = false;
        $contiguousSlotOnY = false;

        // classic direction change check
        switch ($this->currentDirection) {
            case static::DIRECTION_TOP:
                $canContinue = $this->currentY > 0;
                break;
            case static::DIRECTION_RIGHT:
                $canContinue = $this->currentX < $this->currentWidth -1;
                break;
            case static::DIRECTION_BOTTOM:
                $canContinue = $this->currentY < $this->currentHeight -1;
                break;
            case static::DIRECTION_LEFT:
                $canContinue = $this->currentX > 0;
                break;
        }

        // contiguous slots check
        if ($this->isGoingHorizontally()) {
            if ($this->currentX >= 2 && $this->currentX <= $this->currentWidth - 3) {
                $deltaX = $this->currentDirection == static::DIRECTION_RIGHT ? 2 : -2;
                $contiguousSlotOnX = $this->currentBoard->getSlot($this->currentX + $deltaX, $this->currentY)->isUsed();
            }
        }

        if ($this->isGoingVertically()) {
            if ($this->currentY >= 2 && $this->currentY <= $this->currentHeight - 3) {
                $deltaY = $this->currentDirection == static::DIRECTION_BOTTOM ? 2 : -2;
                $contiguousSlotOnY = $this->currentBoard->getSlot($this->currentX, $this->currentY + $deltaY)->isUsed();
            }
        }

        return !$canContinue || $contiguousSlotOnX || $contiguousSlotOnY;
    }

    /**
     * @return SpiralGenerator
     */
   private function turn(): self
   {
       $this->currentDirection = $this->getNextDirection($this->currentDirection, $this->currentWay);

       return $this;
   }

    /**
     * @param string $direction
     * @param string $way
     *
     * @return string
     */
   private function getNextDirection(string $direction, string $way = self::WAY_CLOCKWISE): string
   {
       if ($direction == static::DIRECTION_TOP) {
           return $way == static::WAY_CLOCKWISE
               ? static::DIRECTION_RIGHT
               : static::DIRECTION_LEFT;
       } elseif ($direction == static::DIRECTION_RIGHT) {
           return $way == static::WAY_CLOCKWISE
               ? static::DIRECTION_BOTTOM
               : static::DIRECTION_TOP;
       } elseif ($direction == static::DIRECTION_BOTTOM) {
           return $way == static::WAY_CLOCKWISE
               ? static::DIRECTION_LEFT
               : static::DIRECTION_RIGHT;
       } elseif ($direction == static::DIRECTION_LEFT) {
           return $way == static::WAY_CLOCKWISE
               ? static::DIRECTION_TOP
               : static::DIRECTION_BOTTOM;
       }
   }
}
