<?php
declare(strict_types = 1);

namespace App;

class DotPositionClass {
    const IS_DOT = 0;
    const IS_HOT_SPOT = 1;
    const IS_NOT_DOT = 2;
    const IS_INVALID = 3;

    // x, y
    public $gridMaxSize = [100, 100];
    public $dotPosition = [50, 50];
    public $hotSpotSize = [10, 10];

    public function isDotPosition($position): int
    {
        if ($this->isValidPosition($position) === false) {
            return self::IS_INVALID;
        }

        if ($position === $this->dotPosition){
            return self::IS_DOT;
        }
        elseif ($this->isInHotSpotZone($position) === true) {
            return self::IS_HOT_SPOT;
        }
        else {
            return self::IS_NOT_DOT;
        }
    }

    private function isValidPosition($position)
    {
        if ($position[0] > $this->gridMaxSize[0] || $position[1] > $this->gridMaxSize[1]) {
            return false;
        }
        return true;
    }

    private function isInHotSpotZone($position): bool
    {
        $axis = [0, 1];
        $hotAxis = [];

        foreach ($axis as $axe) {
            $axeRange = [$this->dotPosition[$axe] - $this->hotSpotSize[$axe], $this->dotPosition[$axe] + $this->hotSpotSize[$axe]];
            $axeIsHot = false;

            if ($position[$axe] >= $axeRange[0] && $position[$axe] <= $axeRange[1]) {
                $axeIsHot = true;
            }

            $hotAxis[] = $axeIsHot;
        }

        foreach ($hotAxis as $hotAxe) {
            if ($hotAxe === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getGridMaxSize(): array
    {
        return $this->gridMaxSize;
    }

    /**
     * @param array $gridMaxSize
     */
    public function setGridMaxSize(array $gridMaxSize): void
    {
        $this->gridMaxSize = $gridMaxSize;
    }

    /**
     * @return array
     */
    public function getDotPosition(): array
    {
        return $this->dotPosition;
    }

    /**
     * @param array $dotPosition
     */
    public function setDotPosition(array $dotPosition): void
    {
        $this->dotPosition = $dotPosition;
    }

    /**
     * @return array
     */
    public function getHotSpotSize(): array
    {
        return $this->hotSpotSize;
    }

    /**
     * @param array $hotSpotSize
     */
    public function setHotSpotSize(array $hotSpotSize): void
    {
        $this->hotSpotSize = $hotSpotSize;
    }
}
