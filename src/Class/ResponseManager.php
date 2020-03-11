<?php
declare(strict_types = 1);

namespace App;

Class ResponseManager {
    /** @var DotPositionClass */
    public $dotPosition;
    /** @var array|null */
    public $gridSize;
    /** @var array|null */
    public $hotSpotSize;
    /** @var DotFinderController */
    public $dotController;
    /** @var AttemptInfoClass */
    public $attemptInfo;
    /** @var int|null */
    public $result = DotPositionClass::IS_NOT_DOT;
    /** @var int|null */
    public $attemptsNumber = 0;

    public function __construct()
    {
        $this->dotController = new DotFinderController();
        $this->attemptInfo = new AttemptInfoClass();
        $this->dotPosition = new DotPositionClass();
    }

    public function respondToAttempt(array $attempt): string
    {
        if (!empty(file_get_contents('./cache.txt'))) {
            $result = $_POST['attempt'];

            $this->attemptInfo->buildFromJson(json_decode(file_get_contents('./cache.txt')));
            $this->dotPosition->buildFromJson(json_decode(file_get_contents('./cache.txt'))->dotPosition);

            $this->attemptInfo->setDotPosition($this->dotPosition);
        }

        if ($this->attemptInfo->getFeedback() !== DotPositionClass::IS_DOT) {

            if ($_POST['type'] == 'attempt' && !empty($this->result) && is_array($attempt) && count($attempt) == 2) {
                $this->attemptInfo->setCurrentAttempt($attempt);
                $attemptPosition = $this->dotController->presentAttempt($this->dotPosition, (int)$_POST['feedback'], $this->attemptInfo);
                $result = $this->dotPosition->isDotPosition($attemptPosition);

                file_put_contents('./cache.txt', json_encode($this->attemptInfo));
                if ($result === DotPositionClass::IS_DOT) {
                    file_put_contents('./cache.txt', '');
                }

                header('Content-Type: application/javascript; charset=utf-8');
                return json_encode([$attemptPosition, $result]);
            } else {
                header('Status: 400 Bad Request');
                return 'error';
            }
        }

        return 'Dot found';
    }

    function displayUserInterface(): void {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>DotFinder</title>
            <style>
                .dotgrid {
                    line-height: 4px;
                    font-size: large;
                }
                .hotspot {
                    background-color: red;
                }
                .dot {
                    background-color: greenyellow;
                }
                .try {
                    background-color: bisque;
                }
            </style>
        </head>
        <body>
        <table class="dotgrid">
            <?php
            for ($i=0; $i < $this->dotPosition->getGridMaxSize()[0]; $i++) {
                echo "<tr>";

                for ($y=0; $y < $this->dotPosition->getGridMaxSize()[1]; $y++) {
                    echo "<td data-position=".$i.":".$y.">.</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <button id="start" style="margin-top: 20px">Try</button>
        <script
                src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                crossorigin="anonymous"></script>
        <script type="application/javascript" src="./js/queryDotPosition.js"></script>
        <table style="margin-top: 20px">
            <tr>
                <td>Attempts : <span class="attempts">0</span></td>
            </tr>

            <tr>
                <td>Grid Size : <?php echo $this->gridSize[0].'x'.$this->gridSize[1] ?></td>
                <td>HotSpotSize : <?php echo $this->hotSpotSize[0].'x'.$this->hotSpotSize[1] ?></td>
            </tr>
            <tr>
                <td>! clear the cache if interrupted !</td>
            </tr>
        </table>
        </body>
        </html>
        <?php
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
     * @return array|null
     */
    public function getGridSize(): ?array
    {
        return $this->gridSize;
    }

    /**
     * @param array|null $gridSize
     */
    public function setGridSize(?array $gridSize): void
    {
        $this->gridSize = $gridSize;
    }

    /**
     * @return array|null
     */
    public function getHotSpotSize(): ?array
    {
        return $this->hotSpotSize;
    }

    /**
     * @param array|null $hotSpotSize
     */
    public function setHotSpotSize(?array $hotSpotSize): void
    {
        $this->hotSpotSize = $hotSpotSize;
    }

    /**
     * @return DotFinderController|null
     */
    public function getDotController(): ?DotFinderController
    {
        return $this->dotController;
    }

    /**
     * @param DotFinderController|null $dotController
     */
    public function setDotController(?DotFinderController $dotController): void
    {
        $this->dotController = $dotController;
    }

    /**
     * @return AttemptInfoClass|null
     */
    public function getAttemptInfo(): ?AttemptInfoClass
    {
        return $this->attemptInfo;
    }

    /**
     * @param AttemptInfoClass|null $attemptInfo
     */
    public function setAttemptInfo(?AttemptInfoClass $attemptInfo): void
    {
        $this->attemptInfo = $attemptInfo;
    }

    /**
     * @return int|null
     */
    public function getResult(): ?int
    {
        return $this->result;
    }

    /**
     * @param int|null $result
     */
    public function setResult(?int $result): void
    {
        $this->result = $result;
    }

    /**
     * @return int|null
     */
    public function getAttemptsNumber(): ?int
    {
        return $this->attemptsNumber;
    }

    /**
     * @param int|null $attemptsNumber
     */
    public function setAttemptsNumber(?int $attemptsNumber): void
    {
        $this->attemptsNumber = $attemptsNumber;
    }
}