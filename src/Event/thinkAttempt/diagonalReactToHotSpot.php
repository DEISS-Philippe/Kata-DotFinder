<?php
declare(strict_types = 1);

namespace App\Event;

use App\AttemptInfoClass;
use App\DotPositionClass;
use App\Event\EventMethodInterface;

class diagonalReactToHotSpot implements EventMethodInterface {

    public function eventAction($args)
    {
        /** @var AttemptInfoClass $attemptInfo */
        $attemptInfo = $args[0];

        $position = $attemptInfo->getFormerAttempt();

        // find HotSpot border
        if ($attemptInfo->getFeedback() === DotPositionClass::IS_NOT_DOT && $attemptInfo->hasFoundHotSpot === true && empty($attemptInfo->getClues())) {
            $attemptInfo->addClue('G_3');
            $attemptInfo->setCurrentAttempt([$position[0], $position[1] - 1]);

            return;
        }

        if ($attemptInfo->hasClue('G_3')) {
            if($attemptInfo->getFeedback() === DotPositionClass::IS_NOT_DOT) {
                $attemptInfo->removeClue('G_3');
                $attemptInfo->addClue('AC_4');

                $attemptInfo->setHotSpotX($position[0] - 1);
                $attemptInfo->setCurrentAttempt([$position[0] - 1, $position[1] + 1]);

                return;
            }
            elseif ($attemptInfo->getFeedback() === DotPositionClass::IS_HOT_SPOT) {
                $attemptInfo->removeClue('G_3');
                $attemptInfo->addClue('B_4');

                $attemptInfo->setHotSpotY((int)$position[1]);
                $attemptInfo->setCurrentAttempt([$position[0] + 1, $position[1]]);

                return;
            }
            throw new \Exception('Unexpected outcome');
        }

        if ($attemptInfo->hasClue('B_4')) {
            if ($attemptInfo->getFeedback() === DotPositionClass::IS_NOT_DOT) {
                $attemptInfo->setHotSpotX($position[0] - 1);

                return;
            }
            elseif ($attemptInfo->getFeedback() === DotPositionClass::IS_HOT_SPOT) {
                $attemptInfo->setCurrentAttempt([$position[0] + 1, $position[1]]);

                return;
            }
            throw new \Exception('Unexpected outcome');
        }

        if ($attemptInfo->hasClue('AC_4')) {
            if ($attemptInfo->getFeedback() === DotPositionClass::IS_NOT_DOT) {
                $attemptInfo->setHotSpotY($position[1] - 1);


                return;
            }
            elseif ($attemptInfo->getFeedback() === DotPositionClass::IS_HOT_SPOT) {
                $attemptInfo->setCurrentAttempt([$position[0], $position[1] + 1]);

                return;
            }
            throw new \Exception('Unexpected outcome');
        }

        // crawl HotSpot
        if ($attemptInfo->hasFoundHotSpot === true && (empty($attemptInfo->getHotSpotX()) || empty($attemptInfo->getHotSpotY()))) {
            $attemptInfo->setCurrentAttempt([$position[0] + 1, $position[1] + 1]);
        }
    }
}
