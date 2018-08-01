<?php

include_once(__DIR__ . '/../vendor/autoload.php');

$post = new Phpdx\WebPost($_POST);

if ($post->validate()) {
	$post->process();
	http_response_code(200);
}
else {
	http_response_code(422);
}

?>