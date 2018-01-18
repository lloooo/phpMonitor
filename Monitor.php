<?php
require 'vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

class Monitor
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function crawl()
    {
        $client = new \GuzzleHttp\Client();
        $res    = $client->request('GET', $this->url);
        $body   = $res->getBody();

        return iconv("GBK", "UTF-8", $body->getContents());
    }

    public function listen()
    {
        $data    = $this->crawl();
        $dom     = HtmlDomParser::str_get_html($data);
        $element = $dom->find('table', 5)->innertext();
        $subDom  = HtmlDomParser::str_get_html($element);
        $themes  = $subDom->find('tr');
        foreach ($themes as $theme) {
            if (preg_match('/(速度|水)/', $theme)) {
                preg_match('/http:\/\/www\.zuanke8\.com\/thread.*html/', $theme, $url);
                preg_match('/e=.*ta/', $theme, $title);
                echo rtrim(ltrim($title[0],'e="'),'"  ta') . PHP_EOL . $url[0] . PHP_EOL;
            }
        }
    }
}

$spider = new Monitor('http://www.zuanke8.com/zuixin.php');
while (true) {
    $spider->listen();
    echo PHP_EOL . PHP_EOL;
    sleep(5);
}
