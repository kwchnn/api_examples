<?php 
declare(strict_types=1);
namespace pulsar\backend\controller;

use pulsar\core\Config;

class ExchangeController 
{
    private $data = 'internal error';

    private function getUrl()
    {
        $url = "https://api.bitaps.com/market/v1/ticker/btcusd";

        $ci = curl_init();
        // request 
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_URL, $url);

        $this->data = json_decode(curl_exec($ci));

        curl_close($ci);
    }

    public function getExchange() :string
    {
        $this->getUrl();
        $data = $this->data;
        $array = [
                'last' => $data->data->last,
        ];
        $convert = new StringController($array);
        return $convert->getString();
    }
}
?>