<?php
require 'vendor/autoload.php';
$client = new \GuzzleHttp\Client();
$res = $client->request('GET', 'www.baidu.com');
echo $res->getBody();
