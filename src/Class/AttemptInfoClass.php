<?php

declare(strict_types = 1);

namespace App;

class AttemptInfoClass {
    public $hasFoundHotSpot = false;
    public $hotSpotX;
    public $hotSpotY;

    public $feedback = null;
    /** @var DotPositionClass|null */
    public $dotPosition = null;

    public $currentAttempt = [0, 0];
    public $formerAttempt = [0, 0];

    /**
     * @return array
     */
    public function getFormerAttempt(): array
    {
        return $this->formerAttempt;
    }

    /**
     * @param array $formerAttempt
     */
    public function setFormerAttempt(array $formerAttempt): void
    {
        $this->formerAttempt = $formerAttempt;
    }

    /**
     * @return bool
     */
    public function isHasFoundHotSpot(): bool
    {
        return $this->hasFoundHotSpot;
    }

    /**
     * @param bool $hasFoundHotSpot
     */
    public function setHasFoundHotSpot(bool $hasFoundHotSpot): void
    {
        $this->hasFoundHotSpot = $hasFoundHotSpot;
    }

    /**
     * @return mixed
     */
    public function getHotSpotX()
    {
        return $this->hotSpotX;
    }

    /**
     * @param mixed $hotSpotX
     */
    public function setHotSpotX($hotSpotX): void
    {
        $this->hotSpotX = $hotSpotX;
    }

    /**
     * @return mixed
     */
    public function getHotSpotY()
    {
        return $this->hotSpotY;
    }

    /**
     * @param mixed $hotSpotY
     */
    public function setHotSpotY($hotSpotY): void
    {
        $this->hotSpotY = $hotSpotY;
    }

    /**
     * @return null
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param null $feedback
     */
    public function setFeedback($feedback): void
    {
        $this->feedback = $feedback;
    }

    /**
     * @return DotPositionClass|null
     */
    public function getDotPosition(): ?DotPositionClass
    {
        return $this->dotPosition;
    }

    /**
     * @param DotPositionClass|null $dotPosition
     */
    public function setDotPosition(?DotPositionClass $dotPosition): void
    {
        $this->dotPosition = $dotPosition;
    }

    /**
     * @return array
     */
    public function getCurrentAttempt(): array
    {
        return $this->currentAttempt;
    }

    /**
     * @param array $currentAttempt
     */
    public function setCurrentAttempt(array $currentAttempt): void
    {
        $this->currentAttempt = $currentAttempt;
    }

}