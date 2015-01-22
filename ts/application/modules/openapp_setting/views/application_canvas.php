<script type="text/javascript" src="<?php echo OPENSOCIAL_JS;?>popup.js"></script>
<script type="text/javascript">
	var app_id = <?php echo $application['appid'];?>;
   $(window).bind('beforeunload', function() {
		var ajaxSuggectedFriendRequest;
		var log_id = <?php echo $application['log_id']; ?>;
		ajaxSuggectedFriendRequest = $.ajax({
					url:BASEPATH+'openapp_setting/set_application_log/'+log_id,
					async:false,
					dataType:'html',	
					beforeSend:function(){	
					},
					success: function(data) {	
						return true;
					}
				});
	});
   $("#favorite").live('click',function(){
			var ajaxApplicationFavorite;
			
			ajaxApplicationFavorite = 	$.ajax({
						url:BASEPATH+'openapp_setting/set_application_activity/favorite/'+app_id+'/1',
						dataType:'html',	
						beforeSend:function(){
						},
						success: function(data) {
						 $(".gedged_favorite").html('<span id="un_favorite" class="un_favorite">Remove form Favorites</span>');
						}
					});
			});
   $("#un_favorite").live('click',function(){
		var app_id = <?php echo $application['appid'];?>;
			var ajaxApplicationFavorite;
		ajaxApplicationFavorite = 	$.ajax({
					url:BASEPATH+'openapp_setting/set_application_activity/favorite/'+app_id+'/0',
					dataType:'html',	
					beforeSend:function(){
					},
					success: function(data) {
					 $(".gedged_favorite").html('<span id="favorite" class="favorite">Add to Favorites</span>');
					}
				});
			});
function send_friend_request(){
var app_id = <?php echo $application['appid']; ?>;
ajaxSuggectedFriendRequest = $.ajax({
					url:BASEPATH+'openapp_setting/invites_friends_request_form/'+app_id,
					dataType:'html',	
					async:false,
					beforeSend:function(){	
					},
					success: function(data) {	
						$("#modal").html(data);
						Popup.showModal('modal',null,null,{'screenColor':'#000','screenOpacity':.6});return false;
					}
				});

}
</script>
<script type="text/javascript" src="<?php echo OPENSOCIAL_JS;?>star_rating.js"></script>
<a href="javascript:void(0)" onclick="send_friend_request();">Suggest to Friend</a>
<?php 
$responsetext ='';
	for($i=1;$i<=5;$i++){
		if($application['star_rating'] >= $i)
			$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'gold-rating.png" hspace="1" vspace="0"  alt="'.$application['star_rating'].'%"/>';
		else{
			if($i == intval($application['star_rating'] + .7))
				$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'gold-rating.png" hspace="1" alt="'.$application['star_rating'].'%"/>';
			else
				$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'silver_rating.png" hspace="1" alt="'.$application['star_rating'].'%"/>';
		}
	}
	$id=$this->uri->segment(3);
	$appid=$this->uri->segment(4);
	$data['gadget']=$application;
	$data['gadget']['width'] = 490;
	$data['gadget']['view'] = 'html';
	?>
	<!--app titale and star rating-->
  <div> <span style="float:left;" class="headingTextOSgames"><?php if(!empty($application['title'])){echo $application['title'];}?></span>
	  <div class="ratingOS">Rating
		<div> 
			<?php echo $responsetext; ?>
		</div>
	  </div>
</div>
<!--app titale and star rating end-->
	<?php $this->load->view('gadget/gadget',$data);
	echo "<div style='padding: 25px;'><div class='gedged_favorite' style='cursor: pointer;width:300px;float:left;'>".$application['favorite']."</div>";
?>
<div id="setrating" class="lst" style="float:right;">
	<div onmouseout="setRating(0)">
		<span>Select Rating :</span>
		<img src="<?php echo OPENSOCIAL_IMG;?>rating/rate0.png" id="R1" alt="0" style="cursor:pointer" title="Not at All"/>
		<img src="<?php echo OPENSOCIAL_IMG;?>rating/rate0.png" id="R2" alt="1" style="cursor:pointer" title="Somewhat" />
		<img src="<?php echo OPENSOCIAL_IMG;?>rating/rate0.png" id="R3" alt="2" style="cursor:pointer" title="Average" />
		<img src="<?php echo OPENSOCIAL_IMG;?>rating/rate0.png" id="R4" alt="3" style="cursor:pointer" title="Good" />
		<img src="<?php echo OPENSOCIAL_IMG;?>rating/rate0.png" id="R5" alt="4" style="cursor:pointer" title="Very Good"/>
	</div>
</div>

<div class="PopupDiv" id="modal" style="border: 3px solid black; background-color: #fff; padding: 25px; font-size: 150%; text-align: center; display: none; position: absolute; visibility: visible; top: 195.5px; left: 547.5px; z-index: 134;   width: 450px;">
</div>

</div>
<?php //echo "<div class='gedged_description'><b>".'Description'."</b><br/>".$application['description']."</div>";
?>

