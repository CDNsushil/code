<div>
<link href="<?php echo OPENSOCIAL_CSS;?>stylesheet.css" type="text/css" rel="stylesheet" media="screen" />
<!-- fontkit css -->
<link href="<?php echo OPENSOCIAL_CSS;?>fontswebkit.css" type="text/css" rel="stylesheet" media="screen" />
<!-- jquery dropdown box -->
<script type="text/javascript" src="<?php echo OPENSOCIAL_JS;?>jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo OPENSOCIAL_JS;?>common.js"></script>
<!-- scroller bar plugin -->
<link href="<?php echo OPENSOCIAL_CSS;?>slickscroll.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="<?php echo OPENSOCIAL_JS;?>jquery.mousewheel.js" type="text/javascript"></script>
<script src="<?php echo OPENSOCIAL_JS;?>jquery.slickscroll.js" type="text/javascript"></script>
<script type="text/javascript">

var slickscroll

$(document).ready(function () {
	scroll1 = $('#divMain1').slickscroll({ "verticalscrollbar": true });
});
$("#click_game").live('click',function(){
	$("#game").show();
	$("#app").hide();
});
$("#click_apps").live('click',function(){
	$("#app").show();
	$("#game").hide();
});
</script>


<div class="R_os_text">OpenSocial</div>
<div class="button_apps"> <span><a href="#" id='click_game'><img  title="Games" src="<?php echo OPENSOCIAL_IMG; ?>game.png"></a></span> <span><a href="#" id='click_apps'><img title="Apps" src="<?php echo OPENSOCIAL_IMG; ?>apps.png"></a></span> </div>
<div class="clear"></div>
<div class="slickscrollcontainer" style="width: 205px;">
<?php $style = (count($data['app']) > 5)? 'display:none':'display:block';?>
<div class="slickscroll_vertical_scrollbar" style="height: 176.098px; left: 1180.5px; top: 98.5px;<?php echo $style;?>"><div></div></div>


<div class="slickscroll" id="divMain1" style="-moz-user-select: text; width: 200px;"> 
<div id='app'>
        <?php $i=1; foreach($data['app'] as $app){?>
        <!-- farm villa game 1-->
        <div class="stripBackAPPS stripBackAPPS<?php echo $i++;?>">
          <div class="game_image_os"><a href="<?php echo base_url() . "opensocial/application/".$app->id."/".$app->mod_id; ?>" ><img title="<?php echo $app->title;?>" width ="35" height="35" src="<?php echo openappConfig::get('gadget_server') . "/gadgets/proxy?url=" . urlencode($app->thumbnail); ?>"></a></div>
          <div class="Gametitle_os"><?php echo substr($app->title,0,15);?></div>
          <div class="play_button_os"><a href="<?php echo base_url() . "opensocial/application/".$app->id."/".$app->mod_id; ?>"><img titile="Play" src="<?php echo OPENSOCIAL_IMG; ?>play.png"></a></div>
        </div>
		<?php } ?>
</div>
<div id='game' style="display:none;">
<?php $i=1; foreach($data['game'] as $app){?>
        <!-- farm villa game 1-->
        <div class="stripBackAPPS stripBackAPPS<?php echo $i++;?>">
          <div class="game_image_os"><a href="<?php echo base_url() . "opensocial/application/".$app->id."/".$app->mod_id; ?>" ><img title="<?php echo $app->title;?>" width ="35" height="35" src="<?php echo openappConfig::get('gadget_server') . "/gadgets/proxy?url=" . urlencode($app->thumbnail); ?>"></a></div>
          <div class="Gametitle_os"><?php echo substr($app->title,0,15);?></div>
          <div class="play_button_os"><a href="<?php echo base_url() . "opensocial/application/".$app->id."/".$app->mod_id; ?>"><img titile="Play" src="<?php echo OPENSOCIAL_IMG; ?>play.png"></a></div>
        </div>
		<?php } ?>
</div>	
	</div></div>
	  </div>