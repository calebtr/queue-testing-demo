<?php

namespace Phpdx\Tests;

use Phpdx\MyListener;

class ListenerTests extends \PHPUnit_Framework_TestCase {

    public function testProcessWebPost() {

        $reflectionClass = new \ReflectionClass(MyListener::class);
        $mock = $this->createMock(MyListener::class);

        // replace the Redis service with a dummy
        $reflectionProperty = $reflectionClass->getProperty('redisFactoryClass');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, 'Phpdx\\Tests\\DummyService');

        // create a commands object
        $commands = (object) [
            'confirmationCode' => 'ca1eb2',
        ];

        // invoke the job and assert the results
        $reflectionMethod = $reflectionClass->getMethod('processWebPost');
        $reflectionMethod->setAccessible(true);
        $result = $reflectionMethod->invoke($mock, $commands);

        $this->assertTrue($result);

    }

}