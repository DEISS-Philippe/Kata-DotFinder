<?php

declare(strict_types = 1);

namespace App;

class AttemptInfoClass {
    /** @var bool $hasFoundHotSpot */
    public $hasFoundHotSpot = false;
    public $hotSpotX;
    public $hotSpotY;
    /** @var array */
    public $blackList = [];

    /** @var int|null $feedback */
    public $feedback = null;
    /** @var array $clues */
    public $clues = [];

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

    public function addToBlackList(array $attempt): void
    {
        $this->blackList[] = $attempt;
    }

    public function isInBlackList(array $attempt): bool
    {
        foreach ($this->blackList as $blaclListElement) {
            if ($blaclListElement === $attempt) {
                return true;
            }
        }
        return false;
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
    public function getHotSpotX(): ?int
    {
        return $this->hotSpotX;
    }

    /**
     * @param mixed $hotSpotX
     */
    public function setHotSpotX(int $hotSpotX): void
    {
        $this->hotSpotX = $hotSpotX;
    }

    /**
     * @return mixed
     */
    public function getHotSpotY(): ?int
    {
        return $this->hotSpotY;
    }

    /**
     * @param mixed $hotSpotY
     */
    public function setHotSpotY(int $hotSpotY): void
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

    public function resetCurrentAttempt(): void
    {
        $this->currentAttempt = [0, 0];
    }

    public function buildFromJson(array $arrayFromJson)
    {
        $this->hasFoundHotSpot = $arrayFromJson['hasFoundHotSpot'];
        $this->hotSpotX = $arrayFromJson['hotSpotX'];
        $this->hotSpotY = $arrayFromJson['hotSpotY'];
        $this->feedback = $arrayFromJson['feedback'];
        $this->clues = $arrayFromJson['clues'];

        $this->currentAttempt = $arrayFromJson['currentAttempt'];
        $this->formerAttempt = $arrayFromJson['formerAttempt'];
    }

    /**
     * @return array
     */
    public function getBlackList(): array
    {
        return $this->blackList;
    }

    /**
     * @param array $blackList
     */
    public function setBlackList(array $blackList): void
    {
        $this->blackList = $blackList;
    }

    /**
     * @return array
     */
    public function getClues(): array
    {
        return $this->clues;
    }

    /**
     * @param array $clues
     */
    public function setClues(array $clues): void
    {
        $this->clues = $clues;
    }

    public function removeClue(string $clue): void
    {
        if (isset($this->clues[$clue])) {
            unset($this->clues[$clue]);
        }
    }

    /**
     * @param string $clue
     */
    public function addClue(string $clue): void
    {
        $this->clues[$clue] = '';
    }

    public function hasClue(string $clue): bool
    {
        if (isset($this->getClues()[$clue])) {
            return true;
        }
        return false;
    }

}
