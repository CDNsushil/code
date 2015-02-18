<?php
		if(@$cravedUser || ($action == 'Re:')){
			$searchCravedUser= base_url(lang().'/tmail/searchCravedUser');
		?>
<div class="pr">
	<?php
		$checked='';
		if((!@$cravedUser) && ($action == 'Re:')){
			$checked='checked';
		}
	?>
		<div class="fl ml10">
			<input <?php echo $checked;?> type="checkbox" id="selectAllCheckBox" onclick="checkUncheck(this, 'userListForMail')">&nbsp;Select All
		</div>
		<div id="checkboxMsg" class="fl red">
			<?php echo form_error('recipientsId'); ?><?php echo isset($errors['recipientsId'])?$errors['recipientsId']:''; ?>
		</div>
</div>
<div class="clear"></div>
 <div id="cravedUser" style="height:180px; overflow:auto; position:relative;">
  <?php
	if($action == 'Re:'){
		if(!in_arrayr($reply_user_id,$cravedUser,'id',1)){ 
			$userimage=getImage($messageDetails['imagePath'],'userIcon');
			?>
			<div class="fl width125px mt10 ml10">
				<div class="width125px tac">
					<img width="50" height="50" src="<?php echo $userimage;?>">
				</div>
				<div class="fl widthAuto mt10 mr10">
					<input checked class="CheckBox cb_selectone" type="checkbox" id="<?php echo $reply_user_id;?>" name="recipientsId[]" value="<?php echo $reply_user_id;?>" alt="<?php echo $messageDetails['firstName'].'&nbsp;'.$messageDetails['lastName'];?>" onclick="prepareUserListForMail(this,<?php echo $reply_user_id;?>,'<?php echo $messageDetails['firstName'].'&nbsp;'.$messageDetails['lastName'];?>')" />
				</div>
				<div class="fl widthAuto mt10">
					<?php echo $messageDetails['firstName'].'&nbsp;'.$messageDetails['lastName'];?>
				</div>
			</div>
			<?
		}
	}
  if(is_array(@$cravedUser)){
	foreach($cravedUser as $k=>$value){
		$userimage=getImage($value->imagePath,'userIcon');
		$checked='';
		if((@$reply_user_id==$value->id) && ($action == 'Re:')){
			$checked='checked';
		}
		?>
		<div class="fl width125px mt10 ml10">
			<div class="width125px tac">
				<img width="50" height="50" src="<?php echo $userimage;?>">
			</div>
			<div class="fl widthAuto mt10 mr10">
				<input <?php echo $checked;?> class="CheckBox cb_selectone" type="checkbox" id="<?php echo $value->id;?>" name="recipientsId[]" value="<?php echo $value->id;?>" alt="<?php echo $value->firstName.'&nbsp;'.$value->lastName;?>" onclick="prepareUserListForMail(this,<?php echo $value->id;?>,'<?php echo $value->firstName.'&nbsp;'.$value->lastName;?>')" />
			</div>
			<div class="fl widthAuto mt10">
				<?php echo $value->firstName.'&nbsp;'.$value->lastName;?>
			</div>
		</div>
		<?php
	}
  }
	/* echo "<pre>";
	print_r($cravedUser);
	echo "</pre>"; */ ?>
 </div>
 <br/>
 <div id="userListForMail" style="height:55px; overflow:auto; border-top:1px solid #CCCCCC; font-size:11px;">
	<?php
	if($action=='Re:'){
		?>
		<div id="user<?php echo $reply_user_id?>" class="fl width125px mt10 ml10"><div class="fl widthAuto ptr" onclick="prepareUserListForMail(this,<?php echo $reply_user_id?>)" ><img class="mt3" align="absmiddle" width="12" src="<?php echo base_url('images/icons/delete_grey.png')?>" /></div><div class="fl widthAuto">&nbsp;<?php echo $messageDetails['firstName'].'&nbsp;'.$messageDetails['lastName']?></div></div>
		<?
	}?>
 </div>
 <?php
	}elseif(@$ajaxHit){ ?>
		<tr>
			  <td height="50" valign="middle">
					<p class="m10">No user found.</p>
			  </td>
		</tr>
		<?
}?>
