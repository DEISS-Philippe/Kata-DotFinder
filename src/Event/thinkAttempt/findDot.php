<?php
declare(strict_types = 1);

namespace App\Event;

use App\AttemptInfoClass;
use App\DotPositionClass;
use App\Event\EventMethodInterface;

class findDot implements EventMethodInterface {
    public function eventAction($args): void
    {
        /** @var AttemptInfoClass $attemptInfo */
        $attemptInfo = $args[0];
        /** @var DotPositionClass $dotPosition */
        $dotPosition = $args[1];

        if (!empty($attemptInfo->getHotSpotX()) && !empty($attemptInfo->getHotSpotY())) {

            $x = $attemptInfo->getHotSpotX() - $dotPosition->getHotSpotX();
            $y = $attemptInfo->getHotSpotY() - $dotPosition->getHotSpotY();

            $attemptInfo->setCurrentAttempt([$x, $y]);
        }
    }
}
