<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//Set class to manage cancle icon 
if($getUserType=='inactive'){
	$mt14 = 'mt-14';
}else{
	$mt14 = '';
}
if(isset($participantsId) && !empty($participantsId)){
	$checkedIds = explode(',',$participantsId);
}else{
	$checkedIds = '';
}
?> 
<script type="text/javascript" charset="utf-8">
	var editFormName = "userForm"; // edit and add form name declare here
	var isEditCall = 0;
	
	// Table restore function for cancel button
	function restoreRow ( oTable, nRow ) {
		var fromData=$("#"+editFormName).serializeArray();
		var aData = oTable.fnGetData(nRow);
		// get existing row id
		var getRowId = $('td', nRow);
		var rowMainId = getRowId.attr('editRecordId');
		// This run only for not null data
		if(aData!=null)
		{	
			var jqTds = $('>td', nRow);
			for ( var i=0, iLen=jqTds.length ; i<iLen ; i++ ) {
				oTable.fnUpdate( aData[i], nRow, i, false );
			}
		}
		
		// This section for new create row while editing any row
		if(this.newCreateRow!=undefined)
		{
			oTable.fnDeleteRow(this.newCreateRow);
		}
		// delete new created row if you edit existing record
		if(rowMainId==undefined)
		{
			oTable.fnDeleteRow( nRow );
		}
		oTable.fnDraw();
	}
		
	// validate and action ready 	
	$(document).ready(function() {
			
		var oTable = $('#example').dataTable();
		var nEditing = null;
		
		// validation for blank field
		$("#"+editFormName).validate({
			submitHandler: function() {
				saveRow( oTable, nEditing);
				nEditing = null;
			}
		});
	
		// extend validate for blank error 	
	   $.extend($.validator.messages, {
			required: "" });
		
		//Do action cancel for already exisit record	
		$('#example a.cancel').live('click', function (e) {
			e.preventDefault();
			var nRow = $(this).parents('tr')[0];
			restoreRow ( oTable, nRow )
		});
		
		// Do action cancel for new create record 
		$('#example a.cancel_new').live('click', function (e) {
			e.preventDefault();
			var nRow = $(this).parents('tr')[0];
			oTable.fnDeleteRow( nRow );
		});
	});

	$(document).ready(function(){
		$('div.js_lb_overlay').replaceWith($('.pf'));
	});	
  
</script>
 
 <div class="width905px">
		
		<div class="popup_gredient width905px">
			<div onclick="$(this).parent().trigger('close');" class="popup_close_btn mt-30 mr-20" id="popup_close_btn"></div>
		<div class="popup_gredient width880px">	
 <div id="wrapperL">
	<div class="seprator_20"></div>
	
	<div id="showUserList">
		<div id="container">
			<div id="add" class="tds-button Fright mr23 mb5 dn" onclick="setValInTo(),$(this).parent().trigger('close');"> <button type="button"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Add</div> <div class="icon-save-btn"></div> </span></button></div>
			
			<div id="selectall" class="tds-button Fright mr23 mb5"> <button type="button"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Select all</div> <div class="icon-save-btn"></div> </span></button></div>
			<div id="show_updated" class="orange_color hidden tac f16 pr137"> Record Updated</div>
			<form action="<?php echo base_url('admin/settings/manage_messaging/manage_users_grid'); ?>" method="post" accept-charset="utf-8" name="userForm" id="userForm" novalidate="novalidate">
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
					<thead>
						<tr class="headerBack">
							<th class="pr15">First Name</th>
							<th>Last <br> Name</th>
							<th>EmailId</th>
							<th>Country</th>
							<th>Joined Date</th>
							<th>logged Date</th>
							<th>Status</th>
							<th>Mail<br>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if(!empty($users))  {
						
						foreach($users as $users_listing)
						{
						?>
						<tr>
							<td editRecordId="<?php echo $users_listing['authuid']; ?>" class="tr_width"><?php echo $users_listing['firstName']; ?></td>
							<td class="tr_width"><?php echo $users_listing['lastName']; ?></td>
							<td class="tr_width"><?php echo wordwrap($users_listing['email'], 25, "\n", true); ?></td>
							<td class="tr_width"><?php echo $users_listing['countryName']; ?></td>
							<td class="tr_width"><?php echo $users_listing['created']; ?></td>
							<td class="tr_width"><?php echo $users_listing['last_visit']; ?></td>
							<td class="tr_width70">
								 <?php if($users_listing['active']==1) {
										echo '<span id='.$users_listing['active'].' class="icon_filesent"></span>';
									}else {
										echo '<span id='.$users_listing['active'].' class="icon_blockeduser"></span>';
									}
								?>
								<!-------this for show status------->  
								<span class="visib_hidden"><?php echo $users_listing['active']; ?></span>
							 </td>
							<td class="tr_width70"><?php
							 if(in_array($users_listing['authuid'], $checkedIds)) {
									$sendStatus=1;
									echo '<span id="1" class="email_send ptr" title="Mail already send"></span>';
								}else {
									$sendStatus=0;
									echo '<span id="0" class="email_not_send ptr" title="Mail not send"></span>';
								}
							 ?>
							 <span class="visib_hidden"><?php echo $sendStatus; ?></span>
							 </td> 
							
							<td class="tr_width80">
								<div class="ml10">
								<input type="checkbox" class="case" name="status[]" id="status_<?php echo $users_listing['authuid'];?>" value="<?php echo $users_listing['authuid'] ?>" onclick="setUserInfo('<?php echo $users_listing['authuid'];?>');">
								</div>
							</td>
							
						</tr>
					<?php } } ?>	
					</tbody>
				</table>
			</form>
			<div class="clear"></div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<script>
runTimeCheckBox();

/*Set global array to get user Ids*/
var userVal = new Array(); 

/* Function to set user ids in to field*/
function setValInTo(){
	if(userVal==''){
		$('#add').hide();
	}else{
		$('#add').show();
	}	
	var BASEPATH = "<?php echo base_url();?>";
	var form_data = {userIds: userVal};
	if(userVal!=''){
		$.ajax
		({
			type: "POST",
			url: BASEPATH+"admin/settings/manage_messaging/setEmails",
			data: form_data,
			success: function(data)
			{		
				$('#toUser').val(data);
			}
		});
		return false;
	}	
}

function setUserInfo(Uid){
	var userIds = $('#userIds').val();
	if(userIds!=''){
		userVal = userIds.split(",");
	} 
	if($('#status_'+Uid).attr('checked')){
		userVal.push(Uid);	
	}else{
		userVal.splice( userVal.indexOf(Uid), 1 );
	}
	$('#add').show();
	
	var uniqueNames = [];
	$.each(userVal, function(i, el){
		if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
	});
	
	$('#userIds').val(uniqueNames);
	//if(userVal==''){
		//$('#toUser').val(userVal);
	//}
}	

/*Manage selected users list*/
$(document).ready(function(){
	var userIds = $('#userIds').val();
	if(userIds!=''){
		$('#add').show();
		var userIdArray = userIds.split(","); 
		for(i=0;i<userIdArray.length;i++){
			$('#status_'+userIdArray[i]).attr('checked',true)
		}
	}
	
	/*check user ids on grid next*/
	$("#example_next").click(function () {	
		var userIds = $('#userIds').val();
		
		if(userIds!=''){
		var userIdArray = userIds.split(","); 
		for(i=0;i<userIdArray.length;i++){
			$('#status_'+userIdArray[i]).attr('checked',true)
		}
		$('#userIds').val(userIds);
		}
	});	

	/* Select all Users */			
	$("#selectall").click(function () {	
		$('#add').show();
		var checkIds = $('.case').attr('checked', 'checked');
		var userVals = new Array(); 	
		$('.case:checkbox:checked').each(function(i){
		userVals[i] = $(this).val();  
		});
		//$('#userIds').val(userVal);
		
		for(j=0;j<userVals.length;j++){
			setUserInfo(userVals[j]);
		}
	  });
	
});	
	
	
</script>
