<?php
require 'vendor/autoload.php';
$client = new \GuzzleHttp\Client();
$res = $client->request('GET', 'http://www.zuanke8.com/zuixin.php');
echo $res->getBody();
