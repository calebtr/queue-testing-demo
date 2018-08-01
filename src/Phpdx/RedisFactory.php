<?php

namespace Phpdx;

use Dotenv\Dotenv;
use Predis\Client as PredisClient;

class RedisFactory {

    public static function init() {
        $dotenv = new Dotenv(__DIR__ . '/../../');
        $dotenv->load();

        $options = array(
            'prefix' => getenv('REDIS_PREFIX')
        );
        $redisUrl = sprintf('tcp://%s:%s', getenv('REDIS_HOST'), getenv('REDIS_PORT'));

        $redis = new PredisClient($redisUrl, $options);
        return $redis;
    }

}
