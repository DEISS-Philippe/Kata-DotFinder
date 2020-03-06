<?php
declare(strict_types = 1);

namespace App\Event;

interface EventMethodInterface {
    public function eventAction(array $args);
}