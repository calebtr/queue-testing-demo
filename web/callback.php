<?php

include_once(__DIR__ . '/../vendor/autoload.php');

$post = new Phpdx\WebPost($_POST);

if ($post->validate()) {
    $status = $post->getStatus();
    http_response_code(200);
    echo $status;
}
else {
    http_response_code(422);
}

?>