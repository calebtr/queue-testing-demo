<?php

namespace Phpdx\Tests;

use Phpdx\WebPost;

class WebPostTests extends \PHPUnit_Framework_TestCase {

    public function testProcess() {

        $reflectionClass = new \ReflectionClass(WebPost::class);
        $mock = $this->createMock(WebPost::class);

        // replace the JobClass property with a spy
        $reflectionProperty = $reflectionClass->getProperty('jobClass');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, 'Phpdx\\Tests\\SpyJob');

        // invoke the process method and assert that the result is not empty
        $reflectionMethod = $reflectionClass->getMethod('process');
        $result = $reflectionMethod->invoke($mock);
        $this->assertNotEmpty($result);

        // query the spy listener and assert the correct number of jobs were spawned
        $spy = SpyListener::getInstance();
        $jobsCreated = $spy->getJobs();
        $this->assertEquals(1, count($jobsCreated));

        // asssert that the name of the queue is correct
        /** @var SpyJob $spawned */
        $spawned = $jobsCreated[0];
        $this->assertEquals('my-queue', $spawned->getQueue());

        // assert that the confirmation code we got above is the one we passed to the job
        $commands = $spawned->getCommands();
        $this->assertEquals($result, $commands->confirmationCode);

        $spy->reset();
    }

}