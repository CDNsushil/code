<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//Set class to manage cancle icon 
?> 
<script type="text/javascript" charset="utf-8">
	var editFormName = "msgForm"; // edit and add form name declare here
	var isEditCall = 0;
	// sort table records from modified date desc
	$(document).ready( function() {
		$('#example').dataTable({
			"aaSorting": [[2,'desc']]
		});
	});

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
			var removeConfirm = confirm('Are you sure you want to delete this newsletter?');
			if (removeConfirm == true) {
				e.preventDefault();
				var nRow = $(this).parents('tr')[0];
				var getRowId = $('td', nRow);
				var rowMainId = getRowId.attr('editRecordId');
				// make object from array for data remove
				var form_data = {newsletterId:rowMainId};
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
			url: BASEPATH+"manage_newsletter/delete_newsletter",
			data: form_data,
			success: function(res)
			{	
				$("#show_updated").html('You have successfully remove the Newsletter.').show().fadeOut(5000);
			}
		});
	}
		
</script>
 
<div id="wrapperL">
	<h1><?php echo $this->lang->line('manage_newsletter');?></h1>
	<div class="box menu">
		<a class="activeMenu" href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_newsletter');?>"><?php echo $this->lang->line('admin_Manage_newsletter');?></a>|
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_newsletter/set_newsletter');?>"><?php echo $this->lang->line('add_newsletter');?></a>|
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_newsletter/compose_mail');?>"><?php echo $this->lang->line('send_newsletter');?></a>
	</div>
	<!--Top menu home link -->
	<div class="box" id="showCountryList">
		<div id="container">
			<div id="show_updated" class="orange_color hidden tac f16 pr137"> Record Updated</div>
			<form action="<?php echo base_url('admin/settings/manage_countries/country_list_new'); ?>" method="post" accept-charset="utf-8" name="msgForm" id="msgForm" novalidate="novalidate">
				<table cellpadding="0" cellspacing="0" border="0" class="display inline-block" id="example">
					<thead>
						<tr class="headerBack">
							<th>Title</th>
							<th>Body</th>
							<th><?php echo $this->lang->line('Date');?></th>
							<th>Edit</th>
							<th>Preview</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if(!empty($newsletterList))  {
						
						foreach($newsletterList as $newsletter)
						{
							// set newsletter edit url
							$editLink = site_url().'admin/settings/manage_newsletter/set_newsletter/'.$newsletter['id'];
							// set newsletter view url
							$viewLink = site_url().'admin/settings/manage_newsletter/view_newsletter/'.$newsletter['id'];
							// set newsletter preview url
							$previewLink = site_url().'admin/settings/manage_newsletter/preview_newsletter/'.$newsletter['id'];
						?>
						
						<tr>
							<td editRecordId="<?php echo $newsletter['id']; ?>" class="tr_width width189px ptr" onclick="goTolink('','<?php echo $viewLink;?>')"><?php echo getSubString($newsletter['title'],50) ?></td>
							<td class="tr_width width368px ptr" onclick="goTolink('','<?php echo $viewLink;?>')"><?php echo substr(strip_tags($newsletter['content']),0,80) ?></td>
							<td class="tr_width width125px ptr" onclick="goTolink('','<?php echo $viewLink;?>')"><?php echo  dateFormatView($newsletter['modifiedAt'],'d M Y') ?></td>
							<td>
								<a href="<?php echo $editLink ?>" class="gridBtn formTip mt5 mr39" original-title="Edit"><span class="icon_edit_show"></span></a></td>
							<td>
								<a class="gridBtn formTip mt10 mr39" href="<?php echo $previewLink ?>" target="_blank" title="Preview"><span class="icon_preview_show"></span></a>
							</td> 
							<td>
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

