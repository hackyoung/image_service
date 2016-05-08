<?php
namespace Model\Service\App;

class Verify extends \Leno\Service
{

    protected $method = 'GET';

    protected $appid;

    public function setAppId($appid)
    {
        $this->appid = $appid;
        return $this;
    }

    public function execute()
    {
        $client = new \GuzzleHttp\Client();
        $url = \Leno\Configure::read('app_verify'). '/app/'.$this->appid;
        $response = $client->request('GET', $url);
        return json_decode((string)$response->getBody(), true);
    }
}
