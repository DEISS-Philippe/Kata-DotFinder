<?php

require __DIR__ . '\..\vendor\autoload.php';

use App\DotPositionClass;
use App\ResponseManager;

$responseManager = new ResponseManager();

$gridSize = [100, 100];
$hotSpotSize = [10, 10];

$responseManager->setGridSize($gridSize);
$responseManager->setHotSpotSize($hotSpotSize);

$dotPosition = new DotPositionClass();
$dotPosition->setDotPosition([31, 56]);
$dotPosition->setGridMaxSize($gridSize);
$dotPosition->setHotSpotSize($hotSpotSize);

$responseManager->setDotPosition($dotPosition);
$responseManager->setResult(DotPositionClass::IS_NOT_DOT);
$responseManager->setAttemptsNumber(0);

$maxThreshold = 100;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['attempt']) && !empty($_POST['attempt'])) {
        echo $responseManager->respondToAttempt($_POST['attempt']);
    } else {
        echo 'Invalid data';
    }
} else {
    $responseManager->displayUserInterface($maxThreshold);
}
