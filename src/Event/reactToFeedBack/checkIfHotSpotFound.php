<?php
declare(strict_types = 1);

namespace App\Event;

use App\AttemptInfoClass;
use App\DotPositionClass;
use App\Event\EventMethodInterface;

class checkIfHotSpotFound implements EventMethodInterface
{
    public function eventAction($args) {
        /** @var AttemptInfoClass $attemptInfo */
        $attemptInfo = $args[0];

        if ($attemptInfo->getFeedback() === DotPositionClass::IS_HOT_SPOT) {
            $attemptInfo->setHasFoundHotSpot(true);
        }
    }
}