<?php

namespace App;

interface WeatherInterface
{

    public function getTemp(): String;

    public function getLocation(): String;

    public function getIcon(): String;

    public function getIconDescription(): String;
    
}
