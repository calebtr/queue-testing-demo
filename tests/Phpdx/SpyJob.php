<?php

namespace Phpdx\Tests;

class SpyJob
{
    private $commands;

    private $queue;

    private $priority;

    public function __construct($commands = [], $queue = null, $priority = 0) {

        $this->commands = $commands;
        $this->queue = $queue;
        $this->priority = $priority;

        $spy = SpyListener::getInstance();
        $spy->addJob($this);
    }

    /**
     * @return mixed
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @return mixed
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

}