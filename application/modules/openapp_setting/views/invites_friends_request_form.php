<script type="text/javascript">
function post_form(){
  var items = $("form").serialize();
	$.ajax({
	  type: 'POST',
	  url: '<?php echo BASEURL;echo 'openapp_setting/invites_from_friends_request'; ?>',
	  data: items,
	  dataType: "html", 
	  success: function(data){
			Popup.hide('modal');                      
		}                                      
	});
}
</script>
<div class="h2_normal" style="margin-bottom:40px; !important;">An application request to Friends</div>
<div class="clear"></div>
<div>
<form 	action="<?php echo BASEURL; ?>openapp_setting/invites_from_friends_request" id='FriendsRequest' method="post">
	<?php foreach($friends as $friend){	?>
	<div style="width:150px;height:100px;float:left;">
				  <div class="smallIconImageWrap"><img width="56" height="56" src="<?php echo $friend->pic;?>"></div>
				  <div class="clear"></div>
				  <div class="colorOS1" style="padding-top:10px"><input type="checkbox" name="<?php echo $friend->friend_id;?>" id="<?php echo $friend->friend_id;?>"value="1"><span style="padding-left:10px"><?php echo $friend->fname.' '.$friend->lname;?></div></span>
	</div>
	<?php } ?>
	<div style="clear: both"></div>
	<input type="hidden" id='app_id' name='app_id' value="<?php echo $app_id; ?>" /> 
	<input type="button" class="h1_normal" style="font-size: 40px !important;" value="Send" onclick="post_form()" /> 
	<input type="button" class="h1_big" style="font-size: 40px !important;"  value="Cancel" onclick="Popup.hide('modal')" />
</form>
</div>
