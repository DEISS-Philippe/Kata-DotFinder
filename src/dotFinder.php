<?php
declare(strict_types = 1);

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

while($result !== DotPositionClass::IS_DOT) {
    $attemptPosition = $dotController->presentAttempt($dotPosition, $result, $attemptInfo);

    $result = $dotPosition->isDotPosition($attemptPosition);
    $attemptsNumber++;

    if ($attemptsNumber > 1000) {
        die('Too Much attempts');
    }
}
echo 'attempts : '.$attemptsNumber.PHP_EOL;
