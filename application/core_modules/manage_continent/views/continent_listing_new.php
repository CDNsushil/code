<?php if (!defined('BASEPATH')) exit('No direct script access allowed') ?> 
 
<script type="text/javascript" charset="utf-8">
	var editFormName = "continentForm"; // edit and add form name declare here
	var isEditCall = 0;
		
	// Table restore function for cancel button
	function restoreRow ( oTable, nRow ) {
		var fromData=$("#"+editFormName).serializeArray();
		var aData = oTable.fnGetData(nRow);
		// get existing row id
		var getRowId = $('td', nRow);
		var rowMainId = getRowId.attr('getContinentId');
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
		
		var languageList = '<select size="1" name="lang" id="lang"  class="languageValue required getValueCheck"  style="visibility: visible; width:190px;margin-top:-6px;">';
		<?php
		// get language list show in dropdown
		echo "var languageArray = ".json_encode(getAbbrLangList('')). ";"; 
		?>
		var select = "";
		for (var i in languageArray) {
				if(aData[1]==i) {  select="selected" }else { select="" };
				if(aData[1]==""){ if(i=="Select Language") { select="selected" } };
				languageList += '<option class="languageValue" value="'+i+'" '+select+'>'+languageArray[i]+'</option>';
		}	
		languageList += '</select>';
		
		jqTds[0].innerHTML = '<input type="text" name="continent" id="continent"   class="input_text_box_class getValue getValueCheck required" value="'+aData[0]+'">';
		jqTds[1].innerHTML = languageList;
		if(currentStatus=='t')
			jqTds[2].innerHTML = '<div class="defaultP ml10"><input type="checkbox" name="status" id="status" class="getRadioValue" value="1" checked></div>';
		else
			jqTds[2].innerHTML = '<div class="defaultP ml10"><input type="checkbox" name="status" id="status"  class="getRadioValue" value="0"></div>';
		if(currentStatus==undefined)
			jqTds[3].innerHTML = '<button type="submit" class="edit submitButton formTip" title="Save" onclick="hideTip()"><span class="icon_save_show"></span></button> &nbsp;&nbsp; <a  class="cancel_new formTip" title="Cancel" href="" onclick="hideTip()"><span class="icon_cancel_show mt0 mr98"></span></a>';
		else
			jqTds[3].innerHTML = '<button type="submit" class="edit submitButton formTip" title="Save" onclick="hideTip()"><span class="icon_save_show"></span></button> &nbsp;&nbsp;<a  class="cancel formTip" title="Cancel" href="" onclick="hideTip()"><span class="icon_cancel_show mt0 mr98"></span></a>';
		/* include checkbox js */	
		runTimeCheckBox();
	}
			
	// after edited save record in data and new record show in table row
	function saveRow ( oTable, nRow) {
		var fromData=$("#"+editFormName).serializeArray();
		
		// check status is check and set the value 
		if($('#status').is(':checked')) {
				var statusVal = 1;
			} else {
				var statusVal = 0;
			} 
		// get selected option text for showing
		var languageTxt = 	$('.languageValue option:selected').text()
		var getRowId = $('td', nRow);
		var jqInputs = $('input', nRow);
		var rowMainId = getRowId.attr('getContinentId');
		oTable.fnUpdate(fromData[1].value, nRow, 0, false );// for text box valu update
		oTable.fnUpdate(languageTxt, nRow, 1, false );// select box value update
		if(statusVal==1)
			getRowId[2].innerHTML = '<span id="1" class="icon_filesent"></span>';
		else
			getRowId[2].innerHTML = '<span id="0" class="icon_blockeduser"></span>';
		oTable.fnUpdate( '<a class="edit" href=""><span class="icon_edit_show"></span></a>', nRow, 3, false );
		
		// make object from array for data updating
		var form_data = {continentId:rowMainId,
			continent:fromData[1].value,
			lang:fromData[2].value,
			status:statusVal};
		
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
				var editRowMainId = getEditRowId.attr('getContinentId');
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
		});
				
	});
			
	//-------------add and update continent data---------//
	
	function add_update_row(form_data, nRow)
	{
		var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
		$.ajax
		({
			type: "POST",
			url: BASEPATH+"manage_continent/continent_data_update",
			data: form_data,
			success: function(res)
			{	
				if(form_data.continentId==undefined)
					{
						// This for add inserted id in row
						var getRowId = $('td', nRow);
						getRowId.attr('getContinentId', res);	
						//alert("record inserted");
					}else
					{
						//alert("record updated");
					}
			}
		});
	}
			
	//--------- Function to hide form tip -------//		
	
	function hideTip(rowId){
		$('.tipsy').css({ 'display': 'none' });
	}
</script>
 
 <div id="wrapperL">
	<h1><?php echo $this->lang->line('continentManager');?></h1>
	<!--Top menu home link -->
	<div class="box menu">
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_countries');?>"><?php echo $this->lang->line('countryHomeLink');?></a>
	</div>
	<div class="box" id="showCountryList">
		<div id="container">
			<!--Div for Add button start-->
			<div class="tds-button fl"> <a id="new" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0)"><span class="font_size13 width_122 dash_link_hover"><?php echo $this->lang->line('createContinent');?></span></a></div>
			<div class="clear"></div>
			<!--Div for Add button end-->
			<div class="seprator_10"></div>
				<form action="<?php echo base_url('admin/settings/manage_continent'); ?>" method="post" accept-charset="utf-8" name="continentForm" id="continentForm" novalidate="novalidate">
				<table cellpadding="0" cellspacing="0" border="0" class="display width_400" id="example">
					<thead>
						<tr class="headerBack">
							<th><?php echo $this->lang->line('continentName');?></th>
							<th><?php echo $this->lang->line('lang');?></th>
							<th><?php echo $this->lang->line('admin_status');?></th>
							<th><?php echo $this->lang->line('advert_table_action');?></th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if(!empty($continentList))  {
						
						foreach($continentList as $continentList)
						{
						?>
						<tr>
							<td getContinentId="<?php echo $continentList['id']; ?>" class="tr_width width250px"><?php echo $continentList['continent']; ?></td>
							<td class="tr_width width234px"><?php echo $continentList['lang']; ?></td>
							<td class="tr_width70 width160px">
								 
								 <?php if($continentList['status']=='t')
									{
										echo '<span id='.$continentList['status'].' class="icon_filesent"></span>';
									}else
									{
										echo '<span id='.$continentList['status'].' class="icon_blockeduser"></span>';
									}
									  ?>
									<!-------this for show status------->  
									<span class="visib_hidden"><?php echo $continentList['status']; ?></span>
								 </td>
							<td class="tr_width70 width160px"> <a class="edit formTip" href="" title="Edit" onclick="hideTip()"><span class="icon_edit_show"></span></a></td>
						</tr>
					<?php } } ?>	
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
