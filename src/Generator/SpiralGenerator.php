<?php

namespace Ekkinox\KataSpiral\Generator;

use Ekkinox\KataSpiral\Factory\BoardFactory;
use Ekkinox\KataSpiral\Model\Board;

/**
 * @package Ekkinox\KataSpiral\Generator
 */
class SpiralGenerator
{
    public const MOVE_TOP    = 'top';
    public const MOVE_RIGHT  = 'right';
    public const MOVE_BOTTOM = 'bottom';
    public const MOVE_LEFT   = 'left';

    /**
     * @var BoardFactory
     */
    private $boardFactory;

    /**
     * @param BoardFactory $boardFactory
     */
   public function __construct(BoardFactory $boardFactory)
   {
        $this->boardFactory = $boardFactory;
   }

    /**
     * @param int $width
     * @param int $height
     *
     * @return Board
     */
   public function generate(int $width, int $height): Board
   {
       $board = $this->boardFactory->create($width, $height);

       $board->useSlot(0,0);
       $board->useSlot(0,1);
       $board->useSlot(0,2);
       $board->useSlot(0,3);
       $board->useSlot(0,4);
       $board->useSlot(0,4);

       return $board;
   }
}
