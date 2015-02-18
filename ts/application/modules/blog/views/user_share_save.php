<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<style>
/* Added by gurutva on 14 March*/
.table{
	/*display:table;*/
	/*position:relative;*/
	clear:left;
}
.row{
	/*display:table-row;*/
	clear:left;
	/*position:relative;*/
}
.cell{
	/*display:table-cell;*/
	float:left;
}
.orng_lbl{
	color:#fc5b1f;
	/*height:30px;*/
	width:135px;
	text-align:right;
	font-size:12px;
	padding:0 14px 0 0px;
	line-height:10px;
	border:0px solid;
    font-family: 'GothamMediumRegular';
}
.rowHeight40{
	height:40px;
}
.dblBorder {
    border: 1px solid #A0A0A0;
    color: #939598;
    outline: 3px solid #E1E1E1;
}

.dblBordernoleft {   
	border-right:1px solid #A0A0A0;	
    color: #939598;
    outline: 3px solid #E1E1E1;
}
.clear_seprator {
	clear:both;
	display:block;
	width:100%;
	height:0px;
	line-height:0px;
	font-size:0px;
	height:8px;
	
}
</style>
<?php

$profileImagePath = "media/";//profile image path

if(count($userInfo)>0){
echo form_open('blog/shareUser','id="shareUser"');
echo form_hidden('postId',$postId);

	foreach($userInfo as $userinformation) 
	{
		$userFullName = $userinformation->firstName.'&nbsp;'.$userinformation->lastName;
		$formCheckboxArray =  array( 
			'name' => 'userInfo[]',
			'id' => 'userInfo', 
			'value' => $userinformation->uId, 
			'checked' =>FALSE
		 );
		 $profileImage = $profileImagePath.$userinformation->profileImagePath;
		
		 ?>
		<div class="row rowHeight40">
		<div class="cell">
			<div class="table" style="width:100%;">
				<div class="row" >
					<div class="cell dblBorder" style="vertical-align:middle; height:70px; width:70px; padding:5px;">
						<img style="max-width:70px; min-height:70px; max-height:70px; margin:auto;"  src="<?php echo getImage($profileImage);?>" />
					</div>
					<div class="cell" style="padding-left:10px;">&nbsp;</div>
					<div class="cell" style="min-height:70px; width:150px; padding:5px;">
					<div align="center" style="padding-top:5px;">
					<?php  echo form_checkbox($formCheckboxArray).'&nbsp;'.$userFullName; ?>
					</div>
					</div>
				</div>
			</div>
		</div>
    </div>
		<div class="clear_seprator" > </div>

		 <?php
		 /*echo '<div><img width="83" src="'.getImage($profileImage).'" /> </div>';
		 echo form_checkbox($formCheckboxArray).'&nbsp;'.$userFullName;
		 echo '<br/>';*/
	}//End Foreach
echo form_submit('save','Save');
echo form_close();
}
?>
