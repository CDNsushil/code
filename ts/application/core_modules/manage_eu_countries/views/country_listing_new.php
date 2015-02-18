<?php if (!defined('BASEPATH')) exit('No direct script access allowed') ?> 
<script type="text/javascript" charset="utf-8">
	var editFormName = "countryForm"; // edit and add form name declare here
	var isEditCall = 0;

	// Table restore function for cancel button
	function restoreRow ( oTable, nRow ) {
		var fromData=$("#"+editFormName).serializeArray();
		var aData = oTable.fnGetData(nRow);
		// get existing row id
		var getRowId = $('td', nRow);
		var rowMainId = getRowId.attr('getCountryId');
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
	
		jqTds[0].innerHTML = '<input type="text" name="countryName" id="countryName"   class="input_box_class getValue getValueCheck required" value="'+aData[0]+'">';
		jqTds[1].innerHTML = '<input type="text" name="localName" id="localName" class="input_box_class getValue getValueCheck required" value="'+aData[1]+'">';
		jqTds[2].innerHTML = '<input type="text" name="countryCode" id="countryCode" class="input_box_class getValue getValueCheck required" value="'+aData[2]+'">';
		jqTds[3].innerHTML = '<input type="text" name="vatPercentage" id="vatPercentage" class="input_box_class getValue getValueCheck required number" value="'+aData[3]+'">';
		if(currentStatus==1)
			jqTds[4].innerHTML = '<div class="defaultP ml10"><input type="checkbox" name="status" id="status" class="getRadioValue" value="1" checked></div>';
		else
			jqTds[4].innerHTML = '<div class="defaultP ml10"><input type="checkbox" name="status" id="status"  class="getRadioValue" value="0"></div>';
		if(currentStatus==undefined)
			jqTds[5].innerHTML = '<button type="submit" class="edit submitButton formTip" title="Save" onclick="hideTip()"><span class="icon_save_show"></span></button> &nbsp;&nbsp; <a  class="cancel_new formTip" title="Cancel" href="" onclick="hideTip()"><span class="icon_cancel_show mt0 mr10"></span></a>';
		else
			jqTds[5].innerHTML = '<button type="submit" class="edit submitButton formTip" title="Save" onclick="hideTip()"><span class="icon_save_show"></span></button> &nbsp;&nbsp;<a  class="cancel formTip" title="Cancel" href="" onclick="hideTip()"><span class="icon_cancel_show mt0 mr10"></span></a>';
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
		var continenTxt = 	$('.continentValue option:selected').text()
		var getRowId = $('td', nRow);
		var jqInputs = $('input', nRow);
		var rowMainId = getRowId.attr('getCountryId');
		oTable.fnUpdate(fromData[1].value, nRow, 0, false );// for text box valu update
		oTable.fnUpdate(fromData[2].value, nRow, 1, false );// for text box valu update
		oTable.fnUpdate(fromData[3].value, nRow, 2, false );// for text box valu update 
		oTable.fnUpdate(fromData[4].value, nRow, 3, false );// for text box valu update 
		if(statusVal==1)
			getRowId[4].innerHTML = '<span id="1" class="icon_filesent"></span>';
		else
			getRowId[4].innerHTML = '<span id="0" class="icon_blockeduser"></span>';
		oTable.fnUpdate( '<a class="edit" href=""><span class="icon_edit_show"></span></a>', nRow, 5, false );
		
		// make object from array for data updating
		var form_data = {countryId:rowMainId,
			countryName:fromData[1].value,
			countryLocalName:fromData[2].value,
			countryCode:fromData[3].value,
			vatPercentage:fromData[4].value,
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
		  required: "",
		  number:"" });
			
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
				var editRowMainId = getEditRowId.attr('getCountryId');
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
			
	//-------------add and update eu country data---------//
	
	function add_update_row(form_data, nRow) {
		var BASEPATH = "<?php echo base_url().SITE_AREA_SETTINGS;?>";
		$.ajax
		({
			type: "POST",
			url: BASEPATH+"manage_eu_countries/eu_country_update",
			data: form_data,
			success: function(res)
			{	
				if(form_data.countryId==undefined)
					{
						// This for add inserted id in row
						var getRowId = $('td', nRow);
						getRowId.attr('getCountryId', res);	
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
	<h1><?php echo $this->lang->line('euCountryHeading');?></h1>
	<!--Top menu home link -->
	<div class="box menu">
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_eu_countries');?>"><?php echo $this->lang->line('countryHomeLink');?></a>
	</div>
	<div class="box">
		<div id="container">
			<!--Div for Add button start-->
			<div class="tds-button fl"> <a id="new" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0)"><span class="font_size13 width_130 dash_link_hover"><?php echo $this->lang->line('createEuCountry');?></span></a></div>
			<div class="clear"></div>
			<!--Div for Add button end-->
			<div class="seprator_10"></div>
			<!--Display country listing -->
			<form action="<?php echo base_url('admin/settings/manage_eu_countries/country_list_new'); ?>" method="post" accept-charset="utf-8" name="countryForm" id="countryForm" novalidate="novalidate">
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
					<thead>
						<tr class="headerBack">
							<th><?php echo $this->lang->line('countryName');?></th>
							<th><?php echo $this->lang->line('countryLocalName');?></th>
							<th><?php echo $this->lang->line('countryCode');?></th>
							<th><?php echo $this->lang->line('vatPercentage');?></th>
							<th><?php echo $this->lang->line('admin_status');?></th>
							<th><?php echo $this->lang->line('advert_table_action');?></th>
						</tr>
					</thead>
					<tbody>
<?php 
if(!empty($countyListing))  {
	
	foreach($countyListing as $county_listing)
	{
	?>
	<tr>
		<td getCountryId="<?php echo $county_listing['countryId']; ?>" class="tr_width"><?php echo $county_listing['countryName']; ?></td>
		<td class="tr_width"><?php echo $county_listing['countryLocalName']; ?></td>
		<td class="tr_width"><?php echo $county_listing['countryCode']; ?></td>
		<td class="tr_width"><?php echo $county_listing['vatPercentage']; ?></td>
		<td class="tr_width70">
			 
			 <?php if($county_listing['status']==1)
				{
					echo '<span id='.$county_listing['status'].' class="icon_filesent"></span>';
				}else
				{
					echo '<span id='.$county_listing['status'].' class="icon_blockeduser"></span>';
				}
				  ?>
				<!-------this for show status------->  
				<span class="visib_hidden"><?php echo $county_listing['status']; ?></span>
			 </td>
		<td class="tr_width70"> <a class="edit formTip" href="" title="Edit" onclick="hideTip()"><span class="icon_edit_show"></span></a></td>
	</tr>
<?php } } ?>
</tbody>
				</table>
			</form>
			<div class="clear"></div>
					<?php
	if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?>
		
		<div class="pt15 ml28 mt7 ml0">
			<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_eu_countries/index'),"divId"=>"showCountryList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
		</div>
		<div class="clear"></div>
		
	<?php } ?>
			<div class="clear"></div>
		</div>
	</div>
</div>

