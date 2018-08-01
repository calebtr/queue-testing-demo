<?php

namespace Radiko;

class Listener {

    protected $channel;

    protected $queue;
    
    public function __construct($queue) {

        $this->queue = $queue;

        $connection     = RabbitMQConnectionFactory::getConnection();
        $this->channel = $connection->channel();
        $this->channel->queue_declare( $this->queue, false, true, false, false );

        $callback = function ( $msg ) {
            $result = $this->processJob( $msg );
            if ( $result ) {
                $msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag'] );
            }
            else { // reject messages that weren't proecessed
                $msg->delivery_info['channel']->basic_reject( $msg->delivery_info['delivery_tag'], false );
            }
        };

        $this->channel->basic_qos( NULL, 1, NULL );

        $this->channel->basic_consume( $this->queue, '', false, false, false, false, $callback );

        while ( count( $this->channel->callbacks ) ) {
            $this->channel->wait();
        }

        $this->channel->close();
        $connection->close();

    }

    protected function processJob($msg) {
        $commands = json_decode( $msg->body );

        if (empty($commands->jobName)) {
            throw new \Exception('job has no name');
        }

        if (!method_exists( $this, $commands->jobName)) {
            throw new \Exception(sprintf('%s is not a valid job name'));
        }

        $result = call_user_func(
            array( $this, $commands->jobName),
            $commands
        );

        return $result;
    }

}
