<?php
use \App\Weather\OpenWeatherMap;
// $weather = \App\Setting::fetch('weather');
$weather = true;
$weatherProvider = new OpenWeatherMap;
$weatherProvider->connect(['appid' => '']);
?>
<div class="weathercontainer">
@if( $weather == true)
    <div id="weather" class="weather bevelledinfo">
        <div class="temperature-container">
            <div class="temperature"><?php echo $weatherProvider->getTemp();?><span>°C</span></div>
            <div class="location"><?php echo $weatherProvider->getLocation();?></div>
        </div>
        <div class="icon-container">
            <div class="temp-icon"><img src="http://openweathermap.org/img/wn/<?php echo $weatherProvider->getIcon();?>.png"></div>
            <div class="temp-description"><?php echo $weatherProvider->getIconDescription();?></div>
        </div>
    </div>
@endif
</div>