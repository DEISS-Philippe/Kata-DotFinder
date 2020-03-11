<?php

require __DIR__ . '\..\vendor\autoload.php';

use App\AttemptInfoClass;
use App\DotFinderController;
use App\DotPositionClass;

$gridSize = [100, 100];
$hotSpotSize = [10, 10];

$dotPosition = new DotPositionClass();
$dotPosition->setDotPosition([50, 50]);
$dotPosition->setGridMaxSize($gridSize);
$dotPosition->setHotSpotSize($hotSpotSize);

$dotController = new DotFinderController();
$attemptInfo = new AttemptInfoClass();

$result = DotPositionClass::IS_NOT_DOT;
$attemptsNumber = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $attempt = (array)$_POST['attempt'];

    if (!empty(file_get_contents('./cache.txt'))) {
        $result = $_POST['attempt'];
        $dotPosition = new DotPositionClass();
        $attemptInfo = new AttemptInfoClass();

        $attemptInfo->buildFromJson(json_decode(file_get_contents('./cache.txt')));
        $dotPosition->buildFromJson(json_decode(file_get_contents('./cache.txt'))->dotPosition);

        $attemptInfo->setDotPosition($dotPosition);
    }

    if ($attemptInfo->getFeedback() !== DotPositionClass::IS_DOT) {

        if ($_POST['type'] == 'attempt' && isset($_POST['attempt']) && !empty($result) && is_array($attempt) && count($attempt) == 2) {
            $attemptInfo->setCurrentAttempt($attempt);
            $attemptPosition = $dotController->presentAttempt($dotPosition, $_POST['feedback'], $attemptInfo);
            $result = $dotPosition->isDotPosition($attemptPosition);

            file_put_contents('./cache.txt', json_encode($attemptInfo, true));
            if ($result === DotPositionClass::IS_DOT) {
                file_put_contents('./cache.txt', '');
            }

            header('Content-Type: application/javascript; charset=utf-8');
            echo json_encode([$attemptPosition, $result]);
        }
        else {
            header('Status: 400 Bad Request');
            echo 'error';
        }
    }
    else {
        echo 'Dot found';
    }
}

else {
    // display page
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
        for ($i=0; $i < $dotPosition->getGridMaxSize()[0]; $i++) {
            echo "<tr>";

            for ($y=0; $y < $dotPosition->getGridMaxSize()[1]; $y++) {
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
            <td>Grid Size : <?php echo $gridSize[0].'x'.$gridSize[1] ?></td>
            <td>HotSpotSize : <?php echo $hotSpotSize[0].'x'.$hotSpotSize[1] ?></td>
        </tr>
        <tr>
            <td>! clear the cache if interrupted !</td>
        </tr>
    </table>
    </body>
    </html>
    <?php
}
