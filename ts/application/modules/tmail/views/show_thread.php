<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  ?>
<?php if(isset($data->status_id) && ($data->status_id!=''))
{ $currentId = $data->status_id;	
	} else {
		$currentId = $status_id;		
		}
/*echo $currentId;
echo "<br>";
echo $current_view_id;*/
$current_view_id = (isset($current_view_id) && !empty($current_view_id))?$current_view_id:0;
//echo $current_view_id;
?>

<div class="row width_791">
	<div class="label_wrapper_global cell"> &nbsp; </div>
		<div class="cell frm_element_wrapper pl0">	
			<?php if(isset($mailThreadData) && $mailThreadData && is_array($mailThreadData) && count($mailThreadData) > 0 ) {
				$i=1;
				foreach ($mailThreadData as $mail) {
					 if( $mail['id'] < $current_view_id) {
					
					?>
					<div class="row">
						<div class="fl bg_666 tmailcollspad fr pr15 pb8 bdr_afafaf width_465">
							<div class="bdr_afafaf bg_white mt-1 ml-1 pt10 pb10 pl14">
								<div class="bdr_f15921">
									<div class=" fl width_412 font_opensans font_size11 font_italic lineH22"> 
										Sent <?php echo  dateFormatView($mail['cdate'],'d F Y') ?><br>
										Sent From <span class="display_inline font_opensansSBold"><?php
											echo isGetUserName($mail['sender_id']); ?></span>
										<div class="clear"></div>
										<div class="seprator_10"></div>
									</div>
									<div class="tds-button-top">
										<div class="fl width_30 height_25 bg_white"><span>
											<?php  if(strlen($mail['body']) >=72) {?>
											<div class="replaySlide width_30" toggleDivId="show_hide<?php echo $i?>"></div>
											<?php  } ?>
											</span></div> 
									</div>
									<div class="fr width_30 height_25 bg_666 clr_white font_OpenSansBold font_size18 text_alignC pt5 mr-1"><?php echo $i ?></div>
									<div class="clear"></div>
								</div>             
								<div class="seprator_13"></div>
								<div class="font_OpenSansBold font_size18 clr_444 pb6"><?php if(isset($mail['subject']) && !empty($mail['subject'])) echo $mail['subject'] ?></div>
								<div class="font_size12 clr_444 hideTxt">
									<?php 
									if(isset($mail['body']) && ($mail['body']!='')) {
										   
										    echo  nl2br(substr($mail['body'],0,72)); 
										    //echo $mail['id'];
										} ?>
								</div>
								<div id="show_hide<?php echo $i?>" class="width_412 dn">
									<?php if(isset($mail['body']) && !empty($mail['body'])){
										 echo  nl2br(substr($mail['body'],72,500));
									 }  ?>
								 </div> 
							</div>
						</div>
						
						<div class="clear"></div>
						<div class="seprator_5"></div>
					</div>
					<?php  $i++; 
				} }
			} ?>         
		<div class="clear"></div>
		<div class="seprator_5"></div>      
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.replaySlide').live('click',function(){
			var togDivId = $(this).attr('toggleDivId');
			if($(this).css("background-position")=='-1px -121px'){
				$(this).css("background-position","-1px -144px")

			}else{
				$(this).css("background-position","-1px -121px");
			}
				$('#'+togDivId).slideToggle("slow");
		});	
	});
  
 </script>
