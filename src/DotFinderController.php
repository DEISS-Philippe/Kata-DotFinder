<?php
declare(strict_types = 1);

namespace App;

use App\Event;
use App\Event\EventDispatcher;

class DotFinderController {

    public $eventDispatcher;

    public function __construct()
    {
        $this->eventDispatcher = new EventDispatcher();
    }

    /**
     * @param $attemptInfo AttemptInfoClass
     * @param $feedback
     */
    public function updateAttemptInfo($attemptInfo, $feedback): void
    {
        $attemptInfo->setFeedback($feedback);

        $attemptInfo->setFormerAttempt($attemptInfo->getCurrentAttempt());
        $attemptInfo->addToBlackList($attemptInfo->getFormerAttempt());

        $attemptInfo->resetCurrentAttempt();
    }

    public function presentAttempt(DotPositionClass $dotPosition, int $feedback, AttemptInfoClass $attemptInfo): array
    {
        $this->updateAttemptInfo($attemptInfo, $feedback);

        // --- Events
        $reactToFeedBackEvent = new Event();
        $reactToFeedBackEvent->buildEvent('reactToFeedBack', [$attemptInfo, $dotPosition]);

        // - react to feedback
        $this->eventDispatcher->dispatch($reactToFeedBackEvent);

        $thinkAttemptEvent = new Event();
        $thinkAttemptEvent->buildEvent('thinkAttempt', [$attemptInfo, $dotPosition]);

        // - think about attempt
        $this->eventDispatcher->dispatch($thinkAttemptEvent);

        // --- if No Idea, attempt random
        if ($attemptInfo->getCurrentAttempt() === [0, 0] || $attemptInfo->getCurrentAttempt() === $attemptInfo->getformerAttempt()) {
            $attemptInfo->setCurrentAttempt($this->createRandomAttempt($dotPosition, $attemptInfo));
        }

        return $attemptInfo->getCurrentAttempt();
    }

    function createRandomAttempt(DotPositionClass $dotPosition, AttemptInfoClass $attemptInfo): array
    {
        do {
            $attemptPositionX = rand(0, $dotPosition->getGridMaxSizeX());
            $attemptPositionY = rand(0, $dotPosition->getGridMaxSizeY());

            $attemptPosition = [$attemptPositionX , $attemptPositionY];
        }
        while($attemptInfo->isInBlackList($attemptPosition));

        return $attemptPosition;
    }
}
