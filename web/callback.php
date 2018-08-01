<?php

include_once(__DIR__ . '/../vendor/autoload.php');

$post = new Phpdx\WebPost($_POST);

http_response_code(200);

?>