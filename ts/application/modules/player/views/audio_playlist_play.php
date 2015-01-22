<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="clearbox pb28">
    <div class="playlist fl w94xh94"> <img id="musciImg"  src="<?php echo base_url('images/default_thumb/music_audio_s.jpg'); ?>" alt="" class="max_w94x94" > </div>
     <div class="player_box fl pl18">
        <div id="playlistPlayer" class="myplayer"></div>
        <div id="audioPlayer" class="hulu">  </div>
     </div>
</div>
<?php echo $media;?>
