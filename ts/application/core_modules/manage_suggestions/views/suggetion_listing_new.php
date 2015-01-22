<?php if (!defined('BASEPATH')) exit('No direct script access allowed') ?> 
 
 	<script type="text/javascript" charset="utf-8">

		var editFormName = "suggestionForm"; // edit and add form name declare here
		var isEditCall = 0;
		
		// Table restore function for cancel button
		function restoreRow ( oTable, nRow )
			{
				var fromData=$("#"+editFormName).serializeArray();
				var aData = oTable.fnGetData(nRow);
				// get existing row id
				var getRowId = $('td', nRow);
				var rowMainId = getRowId.attr('getLangId');
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
			function editRow ( oTable, nRow )
			{
				var aData = oTable.fnGetData(nRow);
				var jqTds = $('>td', nRow);
				var getStatus = $('span', nRow);
				var currentStatus = getStatus.attr('id');
				
				jqTds[0].innerHTML = '<input type="text" name="Language" id="Language"   class="input_box_class getValue getValueCheck required" value="'+aData[0]+'">';
				jqTds[1].innerHTML = '<input type="text" name="Language_local" id="Language_local"   class="input_box_class getValue getValueCheck required" value="'+aData[1]+'">';
				jqTds[2].innerHTML = '<input type="text" name="lang_abbr" id="lang_abbr"   class="input_box_class getValue getValueCheck required" value="'+aData[2]+'">';
				
				if(currentStatus==undefined)
					jqTds[3].innerHTML = '<button type="submit" class="edit submitButton" ><span class="icon_save_show"></span></button> &nbsp;&nbsp; <a  class="cancel_new"  href=""><span class="icon_cancel_show"></span></a>';
				else
					jqTds[3].innerHTML = '<button type="submit" class="edit submitButton" ><span class="icon_save_show"></span></button> &nbsp;&nbsp;<a  class="cancel"  href=""><span class="icon_cancel_show"></span></a>';
			}
			
		
			// after edited save record in data and new record show in table row
			function saveRow ( oTable, nRow)
			{
				var fromData=$("#"+editFormName).serializeArray();
				
				// check status is check and set the value 
				if($('#status').is(':checked')) {
						var statusVal = 1;
					} else {
						var statusVal = 0;
					} 
				// get selected option text for showing
				var getRowId = $('td', nRow);
				var jqInputs = $('input', nRow);
				var rowMainId = getRowId.attr('getLangId');
				oTable.fnUpdate(fromData[1].value, nRow, 0, false );// for text box valu update
				oTable.fnUpdate(fromData[2].value, nRow, 1, false );// for text box valu update
				oTable.fnUpdate(fromData[3].value, nRow, 2, false );// for text box valu update
				oTable.fnUpdate( '<a class="edit" href=""><span class="icon_edit_show"></span></a>', nRow, 3, false );
				
				// make object from array for data updating
				var form_data = {langId:rowMainId,
					Language:fromData[1].value,
					Language_local:fromData[2].value,
					lang_abbr:fromData[3].value};
				
				// show update data in table
					oTable.fnDraw();
				
				// updated editable record in database
				add_update_row(form_data, nRow);
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
					
					// Do Action for new create record
					$('#new').click( function (e) {
						
						var checkCreate = null;
						
						$(".getValueCheck").each(function(){
								checkCreate  = "yes";
						});
						
						// This condition for add one row one time	
						if(checkCreate==null)
						{
							e.preventDefault();
							var aiNew = oTable.fnAddData( [ '', '', '', '', '',''] );
							var nRow = oTable.fnGetNodes( aiNew[0] );
							editRow( oTable, nRow);
							nEditing = nRow;
							window.newCreateRow = nEditing;
							
						}else
						{
							// this codition for while editing then create new record
							var getEditRowId = $('td', nEditing);
							var editRowMainId = getEditRowId.attr('getLangId');
								if(editRowMainId!=undefined)
								{
									restoreRow (oTable, nEditing);
									var aiNew = oTable.fnAddData( [ '', '', '', '', '',''] );
									var nRow = oTable.fnGetNodes( aiNew[0] );
									editRow( oTable, nRow);
									window.newCreateRow = nRow;
								}
							$('#'+editFormName).valid();
							return false;
						}	
						
					} );
				
					//Do action cancel for already exisit record	
					$('#example a.cancel').live('click', function (e) {
						e.preventDefault();
						var nRow = $(this).parents('tr')[0];
						restoreRow ( oTable, nRow )
					} );
					
					// Do action cancel for new create record 
					$('#example a.cancel_new').live('click', function (e) {
							e.preventDefault();
							var nRow = $(this).parents('tr')[0];
							oTable.fnDeleteRow( nRow );
					} );
					
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
					} );
				
			} );
			
			//-------------add and update language data---------//
			
			function add_update_row(form_data, nRow)
			{
				var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
				$.ajax
				({
					type: "POST",
					url: BASEPATH+"manage_sugg/language_data_update",
					data: form_data,
					success: function(res)
					{	
						if(form_data.continentId==undefined)
							{
								// This for add inserted id in row
								var getRowId = $('td', nRow);
								getRowId.attr('getLangId', res);	
								//alert("record inserted");
							}else
							{
								//alert("record updated");
							}
					}
				});
			}
		</script>
 
 
 <div id="wrapperL">
		<h1><?php echo $this->lang->line('suggetionManag');?></h1>
		<!--Top menu home link -->
		<div class="box menu">
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_suggestions');?>"><?php echo $this->lang->line('admin_homeLink');?></a>
		</div>
		<div class="box" id="showCountryList">
			<div id="container">
					<form action="<?php echo base_url('admin/settings/manage_lang'); ?>" method="post" accept-charset="utf-8" name="suggestionForm" id="suggestionForm" novalidate="novalidate">
					<table cellpadding="0" cellspacing="0" border="0" class="display width_400" id="example">
						<thead>
							<tr class="headerBack">
								<th><?php echo $this->lang->line('username');?></th>
								<th><?php echo $this->lang->line('subject');?></th>
								<th><?php echo $this->lang->line('suggestion');?></th>
								<th><?php echo $this->lang->line('date');?></th>
							</tr>
						</thead>
						<tbody>
						<?php 
						if(!empty($suggestions)){
							foreach($suggestions as $suggestions){
								if($suggestions['sender_id']!=''){
									$userInfo = showCaseUserDetails($suggestions['sender_id']);
									if(!empty($userInfo['userFullName']) && $userInfo['userFullName'] !=' '){
									?>
										<tr>
											<td class="tr_width width250px"><?php echo $userInfo['userFullName']; ?></td>
											<td class="tr_width width234px"><?php echo $suggestions['subject']; ?></td>
											<td class="tr_width width234px"><?php echo $suggestions['suggestion']; ?></td>
											<td class="tr_width width234px"><?php echo dateFormatView($suggestions['suggestion_date'],'d M Y'); ?></td>
										</tr>
						<?php } } } }?>	
						</tbody>
					</table>
				</form>
				<div class="clear"></div>
			</div>
	    </div>
</div>

<script type="text/javascript">
 
$(document).ready(function(){
	//selectBox();             		          
});		
</script>
