<?php

namespace Ekkinox\KataSpiral\Generator;

use Ekkinox\KataSpiral\Factory\BoardFactory;
use Ekkinox\KataSpiral\Factory\SlotFactory;
use Ekkinox\KataSpiral\Model\Board;
use Ekkinox\KataSpiral\Model\DrawableInterface;

/**
 * @package Ekkinox\KataSpiral\Generator
 */
abstract class AbstractShapeGenerator implements ShapeGeneratorInterface, DrawableInterface
{
    /**
     * @var BoardFactory
     */
    protected $boardFactory;

    /**
     * @var SlotFactory
     */
    protected $slotFactory;

    /**
     * @var Board
     */
    protected $currentBoard;

    /**
     * @var int
     */
    protected $currentWidth = 0;

    /**
     * @var int
     */
    protected $currentHeight = 0;

    /**
     * @var int
     */
    protected $currentX = 0;

    /**
     * @var int
     */
    protected $currentY = 0;

    /**
     * @param BoardFactory $boardFactory
     * @param SlotFactory  $slotFactory
     * @param int          $width
     * @param int          $height
     */
   public function __construct(
       BoardFactory $boardFactory,
       SlotFactory $slotFactory,
       int $width = 0,
       int $height = 0
   ) {
        $this->boardFactory  = $boardFactory;
        $this->slotFactory   = $slotFactory;
        $this->currentWidth  = $width;
        $this->currentHeight = $height;
        $this->currentX      = 0;
        $this->currentY      = 0;
        $this->currentBoard  = $this->createBoard($this->currentWidth, $this->currentHeight);
   }

    /**
     * @inheritdoc
     */
   public function getDrawing(): string
   {
       return $this->currentBoard->getDrawing();
   }

    /**
     * @param int $width
     * @param int $height
     *
     * @return Board
     */
   protected function createBoard(int $width, int $height): Board
   {
       return $this->boardFactory->create($this->slotFactory, $width, $height);
   }
}
