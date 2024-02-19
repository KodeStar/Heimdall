<?php

    namespace App\Weather;

    use App\WeatherInterface;
    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\ConnectException;
    use GuzzleHttp\Exception\GuzzleException;
    use GuzzleHttp\Exception\ServerException;


    class OpenWeatherMap implements WeatherInterface
    {

        protected $details;

        public function connect($params): Void
        {
            $apikey = $params['appid'];
            $client = new Client([
                'http_errors' => false,
                'timeout' => 15,
                'connect_timeout' => 15,
            ]);    
    
            try {
                $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?lat=52.486244&lon=-1.890401&appid='.$apikey.'&units=metric&lang=en');
                $this->details = json_decode($response->getBody());
            } catch (ConnectException $e) {

            }
    
        }


        public function getTemp(): String
        {
            return round($this->details->main->temp);
        }

        public function getLocation(): String
        {
            return $this->details->name;
        }
    
        public function getIcon(): String
        {
            return $this->details->weather[0]->icon;
        }
    
        public function getIconDescription(): String
        {
            return $this->details->weather[0]->description;
        }
    }