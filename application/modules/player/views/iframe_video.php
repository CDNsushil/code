<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
    if($media == NULL) echo '<div style="width:'.$width.'; height:'.$height.';background-color:#313131"><table width="100%" height="100%" >
    <tr style=" text-align: center;vertical-align: middle;"><td>
    <img src="'.getImage($this->config->item('defaultNoMediaImg')).'" /></td></tr></table></div>
    '; 
    else { 
?>
    

    <!-- player skin -->
    <link rel="stylesheet" href="<?php echo base_url('player/flowplayer_new/skin/minimalist.css');?>">

    <style>
    /* site specific styling */
    body {
      font: 12px "Myriad Pro", "Lucida Grande", "Helvetica Neue", sans-serif;
      text-align: center;
      color: #999;
      background-color: #333333;
      margin:0px;
    }

    /* custom player skin */
    .flowplayer { width: 100% !important; height: 100% !important; left:0px !important; top:0px !important; background-color: #222; background-size: cover;}
    .flowplayer .fp-controls { background-color: rgba(0, 0, 0, 0.4)}
    .flowplayer .fp-timeline { background-color: rgba(0, 0, 0, 0.5)}
    .flowplayer .fp-progress { background-color: rgba(241, 89, 42, 1)}
    .flowplayer .fp-buffer { background-color: rgba(115, 115, 115, 1)}
    .flowplayer { 
        background-image: url(<?php echo $mediaFileImage; ?>);
         /*background-size: 904px 505px;*/
         background-size:cover;
        }

    </style>

    <!-- flowplayer depends on jQuery 1.7.1+ (for now) -->
    <script src="<?php echo base_url('templates/new_version/js/jquery.min.js'); ?>"></script>

    <!-- include flowplayer -->
    <script src="<?php echo base_url('player/flowplayer_new/flowplayer.js'); ?>"></script>


    <div    data-swf    =   "<?php echo base_url('player/flowplayer_new/flowplayer.swf');?>"
            class       =   "flowplayer no-toggle play-button"
            style       =   "height:505px; width:904px; left:-11px; top:-10px;" 
            data-key    =   "<?php $this->config->item('flowplayer_key_config'); ?>" 
            data-logo   =   "<?php echo base_url().'images/logo-tod-square.png'; ?>" 
            data-embed  =   "false" data-fullscreen="true" >
        <video>
            <source type="video/mp4" src="<?php echo $media;?>">
        </video>
    </div>
 

<?php } ?>
