<?php
declare(strict_types = 1);

namespace App\Event;

use App\AttemptInfoClass;
use App\DotPositionClass;
use App\Event\EventMethodInterface;

class reactToHotSpot implements EventMethodInterface {

    public function eventAction($args)
    {
        /** @var AttemptInfoClass $attemptInfo */
        $attemptInfo = $args[0];

        $position = $attemptInfo->getFormerAttempt();

        // find HotSpot border
        // if not in HotSpot anymore = border
        if ($attemptInfo->getFeedback() === DotPositionClass::IS_NOT_DOT && $attemptInfo->hasFoundHotSpot === true) {
            if (empty($attemptInfo->getHotSpotX())) {
                $attemptInfo->setHotSpotX($attemptInfo->getFormerAttempt()[0] - 1);
            }
            elseif (empty($attemptInfo->getHotSpotY()) && !empty($attemptInfo->getHotSpotX())) {
                $attemptInfo->setHotSpotY($attemptInfo->getFormerAttempt()[1] - 1);
                // 2 spot found -> next attempt the dot is found
                return;
            }
        }

        // crawl HotSpot
        if ($attemptInfo->hasFoundHotSpot === true && (empty($attemptInfo->getHotSpotX()) || empty($attemptInfo->getHotSpotY()))) {
            if (empty($attemptInfo->getHotSpotX())) {
                $attemptInfo->setCurrentAttempt([$position[0] + 1, $position[1]]);

                return;
            }
            if (empty($attemptInfo->getHotSpotY()) && !empty($attemptInfo->getHotSpotX())) {
                $attemptInfo->setCurrentAttempt([$attemptInfo->getHotSpotX(), $position[1] + 1]);

                return;
            }

            die('error');
        }
    }
}
