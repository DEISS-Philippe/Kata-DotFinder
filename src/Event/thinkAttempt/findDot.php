<?php
declare(strict_types = 1);

namespace App\Event;

use App\AttemptInfoClass;
use App\Event\EventMethodInterface;

class findDot implements EventMethodInterface {
    public function eventAction($args): void
    {
        /** @var AttemptInfoClass $attemptInfo */
        $attemptInfo = $args[0];

        if (!empty($attemptInfo->getHotSpotX()) && !empty($attemptInfo->getHotSpotY())) {

            $x = $attemptInfo->getHotSpotX() - $attemptInfo->getDotPosition()->hotSpotSize[0];
            $y = $attemptInfo->getHotSpotY() - $attemptInfo->getDotPosition()->hotSpotSize[1];

            $attemptInfo->setCurrentAttempt([$x, $y]);
        }
    }
}
