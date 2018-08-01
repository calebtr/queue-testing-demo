<?php

namespace Phpdx\Tests;

class SpyListener
{
    private $jobs = [];

    static private $instance = null;

    private function __construct() {}

    static public function getInstance() {
        return (self::$instance === null) ? self::$instance = new static() : self::$instance;
    }

    public function addJob($job) {
        $this->jobs[] = $job;
    }

    public function getJobs() {
        return $this->jobs;
    }

    public function reset() {
        $this->jobs = [];
    }

}
