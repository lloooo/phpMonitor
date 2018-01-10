<?php
require 'vendor/autoload.php';
$client = new \GuzzleHttp\Client();
$res = $client->request('GET', 'www.zuanke8.com');
echo $res->getBody();
echo '_________done_______';