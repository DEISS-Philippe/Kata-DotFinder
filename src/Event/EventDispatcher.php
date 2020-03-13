<?php
declare(strict_types = 1);

namespace App\Event;

use App\Event;

class EventDispatcher
{
    private $eventsList = [];

    public function __construct()
    {
        $this->eventsList = [
            'reactToFeedBack' => [
                'App\Event\checkIfHotSpotFound',
            ],
            'thinkAttempt' => [
                'App\Event\diagonalReactToHotSpot',
                'App\Event\findDot'
            ],
        ];
    }

    public function dispatch(Event $event)
    {
        if (!isset($this->eventsList[$event->getName()])) {
            return;
        }

        /** @var EventMethodInterface $eventClassName */
        foreach ($this->eventsList[$event->getName()] as $eventClassName) {
            /** @var EventMethodInterface $eventAction */
            $eventAction = new $eventClassName;
            $eventAction->eventAction($event->getArgs());

//            echo $eventClassName.PHP_EOL;
//            echo $event->getArgs()[0]->getHotSpotX().PHP_EOL;
//            echo $event->getArgs()[0]->getHotSpotY().PHP_EOL;
//
//            var_dump($event->getArgs()[0]->getCurrentAttempt());
        }
    }

}
