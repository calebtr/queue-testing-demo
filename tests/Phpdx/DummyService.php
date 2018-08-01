<?php

namespace Phpdx\Tests;

class DummyService
{

    public function __call($method, $arguments) {
        return true;
    }

    public static function init() {
        return new static();
    }

}