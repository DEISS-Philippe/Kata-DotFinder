<?php declare(strict_types=1);

use App\AttemptInfoClass;
use App\DotFinderController;
use App\DotPositionClass;
use PHPUnit\Framework\TestCase;

final class DotFinderTest extends TestCase
{
    public function testDotFinderResponseX(): void
    {
        $dotPosition = new DotPositionClass();
        $dotPosition->setDotPosition([10, 10]);
        $dotPosition->setHotSpotSize([5, 5]);

        $attemptX = 5;
        $attemptY = 10;

        $dotController = new DotFinderController();
        $attemptInfo = new AttemptInfoClass();
        $attemptInfo->setCurrentAttempt([$attemptX, $attemptY]);

        $attempt = $dotController->presentAttempt($dotPosition, DotPositionClass::IS_HOT_SPOT, $attemptInfo);

        $this->assertEquals($attempt, [$attemptX + 1, $attemptY]);
    }

    public function testDotFinderResponseY(): void
    {
        $dotPosition = new DotPositionClass();
        $dotPosition->setDotPosition([10, 10]);
        $dotPosition->setHotSpotSize([5, 5]);

        $attemptX = 10;
        $attemptY = 6;

        $dotController = new DotFinderController();
        $attemptInfo = new AttemptInfoClass();
        $attemptInfo->setCurrentAttempt([$attemptX, $attemptY]);
        $attemptInfo->setHotSpotX($attemptX);

        $attempt = $dotController->presentAttempt($dotPosition, DotPositionClass::IS_HOT_SPOT, $attemptInfo);

        $this->assertEquals($attempt, [$attemptX , $attemptY + 1]);
    }

    public function testDotFinderResponseXY(): void
    {
        $x = 10;
        $y = 10;

        $dotPosition = new DotPositionClass();
        $dotPosition->setDotPosition([$x, $y]);
        $dotPosition->setHotSpotSize([10, 10]);

        $dotController = new DotFinderController();
        $attemptInfo = new AttemptInfoClass();
        $attemptInfo->setCurrentAttempt([9, 10]);

        $attemptInfo->setHasFoundHotSpot(true);
        $attemptInfo->setHotSpotX($x + $dotPosition->getHotSpotSize()[0]);
        $attemptInfo->setHotSpotY($y + $dotPosition->getHotSpotSize()[1]);

        $attempt = $dotController->presentAttempt($dotPosition, DotPositionClass::IS_HOT_SPOT, $attemptInfo);

        $this->assertEquals($attempt, [$x , $y]);
        $this->assertEquals($dotPosition->isDotPosition($attempt), DotPositionClass::IS_DOT);
    }

    public function testDotFinderFindHotSpotXBorder(): void
    {
        $x = 10;
        $y = 10;

        $xHotSpot = 20;
        $yTry = 12;

        $dotPosition = new DotPositionClass();
        $dotPosition->setDotPosition([$x, $y]);
        $dotPosition->setHotSpotSize([10, 10]);

        $dotController = new DotFinderController();
        $attemptInfo = new AttemptInfoClass();
        $attemptInfo->setCurrentAttempt([$xHotSpot + 1, $yTry]);
        $attemptInfo->setHasFoundHotSpot(true);

        $attempt = $dotController->presentAttempt($dotPosition, DotPositionClass::IS_NOT_DOT, $attemptInfo);

        $this->assertEquals($attempt, [$xHotSpot , $yTry + 1]);
        $this->assertEquals($attemptInfo->getHotSpotX(), $xHotSpot);
    }

    public function testDotFinderFindHotSpotYBorder(): void
    {
        $x = 10;
        $y = 10;

        $xHotSpot = 20;
        $yHotSpot = 20;

        $dotPosition = new DotPositionClass();
        $dotPosition->setDotPosition([$x, $y]);
        $dotPosition->setHotSpotSize([10, 10]);

        $dotController = new DotFinderController();
        $attemptInfo = new AttemptInfoClass();
        $attemptInfo->setCurrentAttempt([$xHotSpot, $yHotSpot + 1]);
        $attemptInfo->setHotSpotX(20);
        $attemptInfo->setHasFoundHotSpot(true);

        $attempt = $dotController->presentAttempt($dotPosition, DotPositionClass::IS_NOT_DOT, $attemptInfo);

        $this->assertEquals($attempt, [$x , $y]);
        $this->assertEquals($attemptInfo->getHotSpotY(), $yHotSpot);
    }
}