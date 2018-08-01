<?php

namespace Phpdx;

class WebPost {

    private $jobClass = 'Phpdx\\Job';

	private $post;

	public function __construct($post) {
		$this->post = $post;
	}

	public function getStatus() {
	    $id = $this->post['id'];

        $redis = RedisFactory::init();
        $status = $redis->get($id);
        $redis->disconnect();

        if (!empty($status)) {
            return $status;
        }
    }

	public function validate() {
	    return $this->post['key'] === 'valid';
	}
	
	public function process() {
		$commands = new \stdClass();
		$commands->jobName = 'processWebPost';
		$commands->post = $this->post;

		$confirmationCode =  $this->confirmationCode();
		$commands->confirmationCode = $confirmationCode;

		new $this->jobClass( $commands, 'my-queue' );
		return $confirmationCode;
	}

	private function confirmationCode() {
        return substr(md5(time()), 0, 6);
    }
	
}