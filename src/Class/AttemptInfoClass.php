<?php

declare(strict_types = 1);

namespace App;

class AttemptInfoClass {
    /** @var bool $hasFoundHotSpot */
    public $hasFoundHotSpot = false;
    public $hotSpotX;
    public $hotSpotY;

    /** @var int|null $feedback */
    public $feedback = null;

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
    public function hasFoundHotSpot(): bool
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
     * @return int|null
     */
    public function getFeedback(): ?int
    {
        return $this->feedback;
    }

    /**
     * @param int|null $feedback
     */
    public function setFeedback(int $feedback): void
    {
        $this->feedback = $feedback;
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

    public function buildFromJson($arrayFromJson)
    {
        $this->hasFoundHotSpot = $arrayFromJson->hasFoundHotSpot;
        $this->hotSpotX = $arrayFromJson->hotSpotX;
        $this->hotSpotY = $arrayFromJson->hotSpotY;
        $this->feedback = $arrayFromJson->feedback;

        $this->currentAttempt = $arrayFromJson->currentAttempt;
        $this->formerAttempt = $arrayFromJson->formerAttempt;
    }

}
