<?php
use Sunra\PhpSimple\HtmlDomParser;

require 'vendor/autoload.php';
$client = new \GuzzleHttp\Client();
$res    = $client->request('GET', 'http://www.zuanke8.com/zuixin.php');
$body    = $res->getBody();
$dom     = HtmlDomParser::str_get_html($body);
$element = $dom->find('赚客大家谈');
var_dump($element);

//zuanke8阿里云上dns解析有误, 导致无法连接到主机, 需设置hosts: 36.248.216.30    www.zuanke8.com