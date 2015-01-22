<?php
if(count($userInfo)>0){ ?>
<div class="friendSearchResult">
<?php
	foreach($userInfo AS $key=>$user){
?>
	<div class="search-friend-info" user_id="<?php echo $user->user_id; ?>" name="<?php echo $user->firstname." ".$user->lastname;?>">		
			<div class="fLeft"><img src="<?php echo getimage('user',1,$user->user_id);  ?>" height="30px" width="30px"/></div>
			<div class="fLeft">
				<div class="userNameTxt"><?php echo $user->firstname." ".$user->lastname;?></div>				
			</div>		
			<div class="clear"></div>
	</div>
<?php
	}
	?>	
</div>
<?php	
}
?>



