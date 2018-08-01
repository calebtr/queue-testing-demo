<?php

include_once(__DIR__ . '/../vendor/autoload.php');

$post = new Phpdx\WebPost($_POST);

if ($post->validate()) {
	$confirmationCode = $post->process();
	http_response_code(200);
	echo $confirmationCode;
}
else {
	http_response_code(422);
}

?>