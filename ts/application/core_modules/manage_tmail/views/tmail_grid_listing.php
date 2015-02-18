<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//Set class to manage cancle icon 
?> 
<script type="text/javascript" charset="utf-8">
	var editFormName = "TmailForm"; // edit and add form name declare here
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
		
		// Do action to remove record 
		$('#example a.remove').live('click', function (e) {
			var removeConfirm = confirm('Are you sure you want to delete this Tmail?');
			if (removeConfirm == true) {
				e.preventDefault();
				var nRow = $(this).parents('tr')[0];
				var getRowId = $('td', nRow);
				var rowMainId = getRowId.attr('editRecordId');
	
				// make object from array for data remove
				var form_data = {msgId:rowMainId};
				// remove users record 
				remove_msg_row(form_data);
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
		
		
	//-------------remove user record---------//
	
	function remove_msg_row(form_data) {
		console.log(form_data);
		var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
		$.ajax
		({
			type: "POST",
			url: BASEPATH+"manage_tmail/delete_msg",
			data: form_data,
			success: function(res)
			{	
				$("#show_updated").html('You have successfully remove the Tmail.').show().fadeOut(5000);
			}
		});
	}
	
</script>
 
 <div id="wrapperL">
	<h1><?php echo $this->lang->line('tmailManager');?></h1>
	<div class="box menu">
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_tmail');?>">Home </a>|
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_tmail/compose_tmail');?>"><?php echo $this->lang->line('composeTmail');?></a>
	</div>
	<!--Top menu home link -->
	<div class="box" id="showCountryList">
		<div id="container">
			<div id="show_updated" class="orange_color hidden tac f16 pr137"> Record Updated</div>
			<form action="<?php echo base_url('admin/settings/manage_tmail'); ?>" method="post" accept-charset="utf-8" name="TmailForm" id="TmailForm" novalidate="novalidate">
				<table cellpadding="0" cellspacing="0" border="0" class="display inline-block" id="example">
					<thead>
						<tr class="headerBack">
							<th>Subject</th>
							<th>Body</th>
							<th><?php echo $this->lang->line('Date');?></th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if(!empty($messageLog))  {
						
						foreach($messageLog as $messageLogDetail)
						{
							$msgLink = site_url().'admin/settings/manage_tmail/view_message/'.$messageLogDetail['id'];
						?>
						
						<tr>
							<td editRecordId="<?php echo $messageLogDetail['id']; ?>" class="tr_width width189px ptr" onclick="goTolink('','<?php echo $msgLink;?>')"><?php echo getSubString($messageLogDetail['subject'],50) ?></td>
							<td class="tr_width width368px ptr" onclick="goTolink('','<?php echo $msgLink;?>')"><?php echo substr(strip_tags($messageLogDetail['message']),0,100) ?></td>
							<td class="tr_width width125px ptr" onclick="goTolink('','<?php echo $msgLink;?>')"><?php echo  dateFormatView($messageLogDetail['sentDate'],'d M Y') ?></td>
							<td class="tr_width80">
								<a class="remove formTip mt10 mr39" href="" title="Delete"><span class="icon_delete_show"></span></a>
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

