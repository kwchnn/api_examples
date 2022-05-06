<?php
declare(strict_types=1);
namespace pulsar\backend\controller;

use pulsar\core\Config;

class WeatherController 
{
    private $data;

    private function getWeather()
    {
        $city = " "; //ur city
        $country = " "; //ur language
        $countDay = 1;
        $id = new Config; //выбор своего api ключа

        $url = "http://api.openweathermap.org/data/2.5/forecast?q=$city,$country&cnt=$countDay&lang=ru&mode=json&units=metric&appid=".$id->appId() .""; //api ссылка

        $ch = curl_init(); //открывает сессию
 
        // Настройка запроса
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $this->data = json_decode(curl_exec($ch)); //передача в приватный метод данных уже в декодированном json 
 
        curl_close($ch); //закрывает сессию
    }

    public function getJson() :string
    {
        $this->getWeather(); //Выполнение запроса погоды
        $data = $this->data;
        $array = [  //вовзрат массива  с данными
                'city' => $data->city->name,
                'temp' => $data->list[0]->main->temp,
                'weather' => $data->list[0]->weather[0]->description,
        ]; 
        $convert = new StringController($array); //вызов метода конвертации и передача массива
        return $convert->getString(); //вовзрат уже конвертированного массива в виде строки
    }
}