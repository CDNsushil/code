<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//Set class to manage cancle icon 
if($getUserType=='inactive'){
	$mt14 = 'mt-14';
}else{
	$mt14 = '';
}
?> 
<script type="text/javascript" charset="utf-8">
	var editFormName = "countryForm"; // edit and add form name declare here
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
	
	// edit record form show editable data	
	function editRow ( oTable, nRow ) {
		var aData = oTable.fnGetData(nRow);
		var jqTds = $('>td', nRow);
		var getStatus = $('span', nRow);
		var currentStatus = getStatus.attr('id');
	
		if(currentStatus==1)
			jqTds[6].innerHTML = '<div class="defaultP ml10"><input type="checkbox" name="status" id="status" class="getRadioValue" value="1" checked></div>';
		else
			jqTds[6].innerHTML = '<div class="defaultP ml10"><input type="checkbox" name="status" id="status"  class="getRadioValue" value="0"></div>';
		if(currentStatus==undefined)
			jqTds[7].innerHTML = '<button type="submit" class="edit submitButton formTip ml5" title="Save" onclick="hideTip()"><span class="icon_save_show"></span></button> &nbsp;&nbsp; <a class="cancel_new formTip" title="Cancel" href="" onclick="hideTip()"><span class="icon_cancel_show <?php echo $mt14;?>"></span></a>';
		else
			jqTds[7].innerHTML = '<button type="submit" class="edit submitButton formTip ml5" title="Save" onclick="hideTip()"><span class="icon_save_show"></span></button> &nbsp;&nbsp;<a class="cancel formTip" title="Cancel" href="" onclick="hideTip()"><span class="icon_cancel_show <?php echo $mt14;?>"></span></a>';
		/* include checkbox js */	
		runTimeCheckBox();
	}
		
	// after edited save record in data and new record show in table row
	function saveRow ( oTable, nRow) {
		// check status is check and set the value 
		if($('#status').is(':checked')) {
			var statusVal = 1;
		} else {
			var statusVal = 0;
		} 
		// get selected option text for showing
		var getRowId = $('td', nRow);
		var jqInputs = $('input', nRow);
		var rowMainId = getRowId.attr('editRecordId');
		if(statusVal==1)
			getRowId[6].innerHTML = '<span id="1" class="icon_filesent"></span>';
		else
			getRowId[6].innerHTML = '<span id="0" class="icon_blockeduser"></span>';
		oTable.fnUpdate( '<a class="edit" href=""><span class="icon_edit_show"></span></a>', nRow, 7, false );
		
		// make object from array for data updating
		var form_data = {status:statusVal,tdsUid:rowMainId};
		
		// show update data in table
		oTable.fnDraw();
		
		// updated editable record in database
		add_update_row(form_data);
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
		
		// Do action to remove record 
		$('#example a.remove').live('click', function (e) {
			var removeConfirm = confirm('Are you sure you want to delete this user?');
			if (removeConfirm == true) {
				e.preventDefault();
				var nRow = $(this).parents('tr')[0];
				var getRowId = $('td', nRow);
				var rowMainId = getRowId.attr('editRecordId');
	
				// make object from array for data remove
				var form_data = {tdsUid:rowMainId};
				// remove users record 
				remove_user_row(form_data);
				oTable.fnDeleteRow( nRow );
			}else{
				return false
			}
		});
		
		// Do action for editing a record
		$('#example a.edit').live('click', function (e) {
			e.preventDefault();
			/* Get the row as a parent of the link that was clicked on */
			var nRow = $(this).parents('tr')[0];
			
			if ( nEditing !== null && nEditing != nRow ) {
				/* Currently editing - but not this row - restore the old before continuing to edit mode */
				restoreRow( oTable, nEditing );
				editRow( oTable, nRow );
				nEditing = nRow;
			}
			else if ( nEditing == nRow && this.innerHTML == "Save" ) {
				
				/* Editing this row and want to save it */
				saveRow( oTable, nEditing);
				nEditing = null;
			}
			else {
				/* No edit in progress - let's start one */
				editRow( oTable, nRow );
				nEditing = nRow;
				if(isEditCall > 0)
				{
					restoreRow ( oTable, window.newCreateRow)
				}
				isEditCall++;
			}
		});
	});
		
	//-------------add and update country data---------//
	
	function add_update_row(form_data)
	{
		console.log(form_data);
		var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
		$.ajax
		({
			type: "POST",
			url: BASEPATH+"manage_users/updateStatus",
			data: form_data,
			success: function(res)
			{	
				$("#show_updated").show().fadeOut(5000);
			}
		});
	}
		
	//-------------remove user record---------//
	
	function remove_user_row(form_data) {
		console.log(form_data);
		var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
		$.ajax
		({
			type: "POST",
			url: BASEPATH+"manage_users/removeUserRecord",
			data: form_data,
			success: function(res)
			{	
				$("#show_updated").html('You have successfully remove the user.').show().fadeOut(5000);
			}
		});
	}
		
	//--------- Function to hide form tip -------//		
	
	function hideTip(rowId) {
		$('.tipsy').css({ 'display': 'none' });
	}
	
</script>
 
 <div id="wrapperL">
	<h1>Users Manager</h1>
	<!--Top menu home link -->
	<div class="box menu user_menu">
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_users');?>" <?php if($getUserType=="allUser"){ ?> class="active_link"<?php }?>><?php echo $this->lang->line('allUsers');?></a> |  
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_users/getAllActiveUsers');?>" <?php if($getUserType=="active"){ ?> class="active_link"<?php }?>><?php echo $this->lang->line('activeUsers');?></a> | 
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_users/getAllInActiveUsers');?>" <?php if($getUserType=="inactive"){ ?> class="active_link"<?php }?>><?php echo $this->lang->line('inactiveUsers');?></a> 
		
	</div>
	<div class="box" id="showCountryList">
		<div id="container">
			<div id="show_updated" class="orange_color hidden tac f16 pr137"> Record Updated</div>
			<form action="<?php echo base_url('admin/settings/manage_countries/country_list_new'); ?>" method="post" accept-charset="utf-8" name="countryForm" id="countryForm" novalidate="novalidate">
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
					<thead>
						<tr class="headerBack">
							<th>First Name</th>
							<th>Last Name</th>
							<th>EmailId</th>
							<th>Country</th>
							<th>Joined Date</th>
							<th>logged Date</th>
							<th>Status</th>
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
							<td class="tr_width80">
								<a class="edit formTip" title="Edit" href="" onclick="hideTip()"><span class="icon_edit_show"></span></a>
								<?php if(!empty($getUserType) && $getUserType=='inactive' && empty($users_listing['last_visit'])) {?>
									<a class="remove formTip" href="" title="Delete"><span class="icon_delete_show"></span></a>
								<?php }?>
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

