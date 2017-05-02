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
     * @var bool
     */
    private $used = false;

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
