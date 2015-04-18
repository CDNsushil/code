<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

 <div class="Main_btn_wp">
  <div class="Main_btn_box" style="padding-left:20px;">
   <div class="Main_btn_left">
    <div class="Main_btn_right"> <?php echo anchor('work/workOffered', $label["workOffered"]);?> </div>
    <!--Main_btn_right-->
   </div>
   <!--Main_btn_left-->
  </div>
  <!--main_btn_wp-->
  <div class="Main_btn_box">
   <div class="Main_btn_left">
    <div class="Main_btn_right"> <?php echo anchor('work/workWanted', $label["workWanted"]);?> </div>
    <!--Main_btn_right-->
   </div>
   <!--Main_btn_left-->
  </div>
  <!--main_btn_wp-->
  <div class="Main_btn_box">
   <div class="Main_btn_left">
    <div class="Main_btn_right"> <?php echo anchor('work/workAppliedFor', $label["workAppliedFor"]);?> </div>
    <!--Main_btn_right-->
   </div>
   <!--Main_btn_left-->
  </div>
  <!--main_btn_wp-->
  <div class="Main_btn_box  Main_select">
   <div class="Main_btn_left">
    <div class="Main_btn_right"> <?php echo anchor('work/workApplicationsReceived', $label["workApplicationsReceived"]);?> </div>
    <!--Main_btn_right-->
   </div>
   <!--Main_btn_left-->
  </div>
  <!--main_btn_wp-->
 </div>
 <!--Main_btn_wp-->
 <div class="frm_wp">
  <div class="block-main" id="block-form">
   <table width="100%" border="0" cellspacing="2" style="font-size:11px;">
    <tr>
     <td>
	 <table width="100%" border="0" cellspacing="2" style="border:0px solid #999999;">
       <tr>
        <td valign="top" style="border-bottom:1px solid #CCCCCC;">
		<table width="100%" border="0" cellspacing="2" style="border:0px solid #999999;">
    
         </table>
	  </td>
      </tr>
      <tr>
        <td valign="top" style="border-bottom:1px solid #CCCCCC;">
	<?php
	if(count($workAppReceived)>0){
	echo form_open('work/deleteWorkApp','name="workApp"','id="workApp"');
	//echo '<pre />';print_r($workAppReceived);
	echo form_hidden('workcheckbox');
	echo form_hidden('workReturnAction',$this->router->method);
	foreach($workAppReceived as $workId =>$rowsApplicationReceived)
	{
	$checkboxClass = $workId;
	//echo '<pre />'.$workId;print_r($rowsApplicationReceived);
	$countAppId = count($rowsApplicationReceived['appId']);
	?>
	<table cellpadding="0" cellspacing="2" border="1px" width="100%" > 
	
	<tr><td colspan="8"><div class="title-content">
	<div class="title-content-left">
	<div class="title-content-right">
	<div class="title-content-center">
	<div class="title-content-center-label"><?php echo $rowsApplicationReceived['workTitle']; ?></div>
	<div class="tds-button-top">
	<?php echo anchor('javascript://void(0);', '<span><div class="projectDeleteIcon"></div></span>',"onclick=deleteGallery(".$checkboxClass.");"); ?>
			
	<!--<a href="javascript:void(0);" onclick="deleteGallery(<?php echo $checkboxClass;?>);" class="tooltip" title="Delete selected."><img src="<?=base_url();?>images/icons/icon-cancel.png" class="icon-cancel" /></a> -->
	<!-- Delete button for multiple or single deleted on selection of checkboxes -->	
	</div>
	<div class="clearfix" > </div>
	</div><!--End title-content-center-label-->
	</div><!--End title-content-center-->
	</div><!--title-content-right-->
	</div><!--End title-content-left--></td></tr>
	 <tr>
	  <th width="24" align="center" valign="middle" bgcolor="#E6E6E6">
	  <input type="checkbox" name="checkbox6" id="checkbox6" onclick="toggleChecked(this.checked,'<?php echo $checkboxClass;?>')" />
	  </th>
	  <th height="24" colspan="2" bgcolor="#E6E6E6">Applicants</th>
	  <th bgcolor="#E6E6E6">Industry</th>
	  <th width="69" bgcolor="#E6E6E6">Showcase</th>
	  <th width="58" bgcolor="#E6E6E6">Work Profile</th>
	  <th width="97" bgcolor="#E6E6E6">Date</th>
	  <th bgcolor="#E6E6E6">Tmail</th>
	</tr>
	<tr>  
	<?php
	for($i=0;$i < $countAppId ;$i++) {
	?>
	<tr>
                      <td align="center" valign="top">
					  <input type="checkbox" name="workcheckbox_<?php echo $checkboxClass;?>[]" id="checkbox" value="<?php echo $rowsApplicationReceived['appId'][$i];?>" class="<?php echo $checkboxClass;?>" /></td>
                      <td width="53" height="20" align="center"><img src="../images/People/rose.jpg" width="50" /></td>

                      <td width="291"> <?php
					   $appliedUserName = $rowsApplicationReceived['username'][$i];
					  echo $appliedUserName; 
					   /*?><a href="#" class="tooltip" title="If work profile associated then profile Synopsis will come in tooltip Else user's log line."><?php 
=======
                      <td width="291"><!-- <a href="#" class="tooltip" title="If work profile associated then profile Synopsis will come in tooltip Else user's log line."> --><?php 
>>>>>>> .r522
					  $appliedUserName = $rowsApplicationReceived['username'][$i];
<<<<<<< .mine
					  echo $appliedUserName; ?></a><?php */?></td>

					

                      <td align="center"><?php echo $rowsApplicationReceived['workIndustry'][$i];?></td>

                      <td align="center"><!-- <a href="#" class="tooltip" title="view user's showcase">View</a>-->N/A</td>
                      <td align="center">N/A</td>
                      <td align="center"><div align="center"><?php $dateApplied = date("d.m.y", strtotime($rowsApplicationReceived['dateApplied'][$i]));
					  echo $dateApplied;?></div></td>
                      <td align="center"><a href="#" class="formTip" title="Take the user to communication thread (Tmail)"><img src="<?=base_url();?>images/icons/1316258607_comment_add.png" width="16" height="16" /></a><a href="<?php echo $rowsApplicationReceived['tmail'][$i];?>"></a></td>
                    </tr>
	<?php
	}
	//To assing the name of user who posted the work	


		
			
			}echo form_close();
			}
			else echo '<div align="center">'.$label['noWorkFound'].'</div>';
		?>
		 </table></td>
       </tr>
      </table></td>
    </tr>
   </table>
  </div><!-- End Div class="block-main" -->
 </div><!-- End Div class="frm_wp" -->
<script language="javascript" type="text/javascript">


//Delete the selected gallery image if no gallery is selected alert with message

function deleteGallery(isSelected){

  var n = $('.'+isSelected).attr('checked');

	if(n>0){
		var conBox = confirm("Are you sure you want to delete the selected work(s)." );
			if(conBox){
				document.workApp.workcheckbox.value = isSelected;
				document.workApp.submit();
			}
			else{
				return false;
			}		
	}else{
		alert('Please tick the checkbox(s) to delete');
		return false;
	}
}



function toggleChecked(status,checkboxClass) {
$("."+checkboxClass).each( function() {
$(this).attr("checked",status);
})
}
</script>