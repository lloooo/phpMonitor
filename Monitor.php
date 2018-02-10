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
        $data = $this->crawl();
        $dom  = HtmlDomParser::str_get_html($data);
//        $this->parseTable($dom,5);
        $this->parseTable($dom,6);
    }

    /**
     * @param $dom \simplehtmldom_1_5\simple_html_dom
     * @param $tableIndex
     */
    private function parseTable($dom, $tableIndex)
    {
        $elementObj = $dom->find('table', $tableIndex);
        if (is_null($elementObj)) {
            echo 'get null , relisten';

            return;
        }
        $element = $elementObj->innertext();
        $subDom  = HtmlDomParser::str_get_html($element);
        $themes  = $subDom->find('tr');
        foreach ($themes as $theme) {
            if (preg_match('/(速度|水|快|好价|还款)/', $theme)) {
                preg_match('/http:\/\/www\.zuanke8\.com\/thread.*html/', $theme, $url);
                preg_match('/e=.*ta/', $theme, $title);
                echo rtrim(ltrim($title[0], 'e="'), '"  ta') . PHP_EOL . $url[0] . PHP_EOL;
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
