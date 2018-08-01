<?php

namespace Phpdx\Tests;

class DummyObject
{

    public function __call($method, $arguments) {
        return true;
    }

    public static function init() {
        return new static();
    }

}