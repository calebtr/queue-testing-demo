<?php

namespace Phpdx;

use PhpAmqpLib\Message\AMQPMessage;

class Job {

    protected $queue;

    /**
     * Job constructor.
     * @param \stdClass $body
     * @param string $queue
     * @throws \Exception
     */
    public function __construct(\stdClass $body, $queue = '') {

        if ($queue) {
            $this->queue = $queue;
        }

        if (empty($this->queue)) {
            throw new \Exception('No queue defined');
        }

        $connection = RabbitMQConnectionFactory::getConnection();

        $channel = $connection->channel();

        $channel->queue_declare( $this->queue, false, true, false, true );

        $msg = new AMQPMessage( json_encode( $body ) );
        $channel->basic_publish( $msg, '', $this->queue );

        $channel->close();
        $connection->close();

    }
    
}