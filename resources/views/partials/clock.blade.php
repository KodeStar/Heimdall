<?php
//$clock = \App\Setting::fetch('clock');
$clock = true;
?>
<div class="clockcontainer">
@if( $clock == 'true')
    <div id="clock" class="clock bevelledinfo"><div class="time"></div><div class="date"></div></div>
@endif
</div>