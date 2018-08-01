<?php

namespace Phpdx;

class MyListener extends Listener {

    private $redisFactoryClass = 'Phpdx\RedisFactory';

    /**
     * Processes some insanely long job.
     *
     * @param $commands
     * @return bool
     */
    protected function processWebPost($commands) {
        sleep(5);
        $redis = $this->redisFactoryClass::init();
        $redis->set($commands->confirmationCode, 'complete', 'ex', 3600);
        $redis->disconnect();

        return true;
    }

    /**
     * Reports error if worker dies.
     */
    public function shutdown() {
        $error = error_get_last();
        if ($error['type'] === E_ERROR) {
            error_log(sprintf('%s shut down: %s', __CLASS__, json_encode($error)));
        }
    }

}
