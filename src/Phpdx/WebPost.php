<?php

namespace Phpdx;

class WebPost {

	private $post;
	
	public function __construct($post) {
		$this->post = $post;
	}
	
	public function validate() {
		return true;
	}
	
	public function process() {
		$commands = new \stdClass();
		$commands->jobName = 'processWebPost';
		$commands->post = $this->post;

		new Job( $commands, 'my-queue' );
	}
	
}