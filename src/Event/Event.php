<?php
declare(strict_types = 1);

namespace App;

class Event
{
    public $args = [];
    public $name = '';

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function buildEvent(string $name, array $args)
    {
        $this->name = $name;
        $this->args = $args;
    }
}
