<?php

require __DIR__ . '\..\vendor\autoload.php';

use App\AttemptInfoClass;
use App\DotFinderController;
use App\DotPositionClass;

$dotPosition = new DotPositionClass();
$dotPosition->setDotPosition([38, 20]);
$dotPosition->setHotSpotSize([10, 10]);

$dotController = new DotFinderController();
$attemptInfo = new AttemptInfoClass();

$result = DotPositionClass::IS_NOT_DOT;
$attemptsNumber = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $attempt = (array)$_POST['attempt'];

    // cache bug !
    if (!empty(file_get_contents('./cache.txt'))) {
        $dotPosition = new DotPositionClass();
        $attemptInfo = new AttemptInfoClass();

        $attemptInfo->buildFromJson(json_decode(file_get_contents('./cache.txt')));
        $dotPosition->buildFromJson(json_decode(file_get_contents('./cache.txt'))->dotPosition);

        $attemptInfo->setDotPosition($dotPosition);
    }

    if ($_POST['type'] = 'attempt' && isset($_POST['attempt']) && !empty($_POST['attempt']) && is_array($attempt) && count($attempt) == 2) {
        $attemptInfo->setCurrentAttempt($attempt);
        $attemptPosition = $dotController->presentAttempt($dotPosition, $result, $attemptInfo);
        $result = $dotPosition->isDotPosition($attemptPosition);

        file_put_contents('./cache.txt', json_encode($attemptInfo, true));
        if ($result = DotPositionClass::IS_DOT) {
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
    // display page
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>DotFinder</title>
        <style>
            * {
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
        <table>
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
        <button id="start" style="margin-top: 20px">GO</button>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
        <script type="application/javascript" src="./js/queryDotPosition.js"></script>
    </body>
    </html>
    <?php
}
