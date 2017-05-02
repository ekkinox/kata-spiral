<?php

namespace Ekkinox\KataSpiral\Model;

/**
 * @package Ekkinox\KataSpiral\Model
 */
class Slot implements DrawableInterface
{
    private const FREE_DRAWING = '.';
    private const USED_DRAWING = '@';

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var bool
     */
    private $used = false;

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     *
     * @return Slot
     */
    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     *
     * @return Slot
     */
    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->used;
    }

    /**
     * @return bool
     */
    public function isFree(): bool
    {
        return !$this->used;
    }

    /**
     * @param bool $used
     *
     * @return Slot
     */
    public function setUsed(bool $used): Slot
    {
        $this->used = $used;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDrawing(): string
    {
        return $this->used ? static::USED_DRAWING : static::FREE_DRAWING;
    }
}
