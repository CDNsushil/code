<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($header) ){
	echo $header;
}
if(isset($like) && !empty($like)) {
	$searchValue = $like; //set value of search
} else {
	$searchValue = $this->lang->line('keywordSearch'); //set default value of search
}
?>
<div class="row position_relative">
	<div class="cell shadow_wp strip_absolute">
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
			<tbody><tr>
				<td height="271">	<img src="http://localhost/toadsquare/images/shadow-top.png"></td>
			</tr>
			<tr>
				<td class="shadow_mid">&nbsp;</td>
			</tr>
			<tr>
				<td height="271"><img src="http://localhost/toadsquare/images/shadow-bottom.png"></td>
			</tr>
		</tbody>
		</table>
	</div>
	<?php if($userId==$ownerId){?>
	<div class="row"> 
		
		<div class="label_wrapper cell">
			<label class="select_field">Add Membes</label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<div class="row pt5 pl12">
				
				<div class="width200px cell">
					<div id="displaySearchInputDiv" class="cell search_box_wrapper">
                    	<input id="searchToadMember" type="text" class="search_text_box" value="<?php echo $searchValue;?>" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
                        <div class="search_btn_glass ptr" onclick="openLightBox('popupBoxWp','popup_box','/collaboration/getToadUsers',$('#searchToadMember').val())">
                        </div>
					</div>
				</div>
				
				<!-- Selected user start-->
				<div class="cell width300px dn" id="selectedUserDiv">
				
				<div class="cell frm_element_wrapper">
				<div class="cell ml10 mr10" id="memberName"> 
				</div>
				<div class="cell">
					<input type="hidden" id="member_id" value="">
					<input type="hidden" id="collaborationId" value="0">
					<div class="small_btn mr0 ml5">
					<a href="javascript://void(0);" class="formTip go fl dn" title="Cancel" onclick="$('#selectedUserDiv').hide()" id="catCancel"><span><div id="catCancel" class="cat_smll_cancel_icon"></div></span></a>					</div>
					<div class="small_btn mr0">
					<a href="javascript://void(0);" class="formTip go fl" onclick="saveCollaborationMember();" original-title="Save"><span><div id="addCatButton" class="cat_smll_save_icon"></div></span></a>					</div>
					
		</div><!-- padding-left:5px; -->
		</div>
				</div>
				<!-- Selected user end-->
				
				
				<div class="clear seprator_20"></div>
			</div>
		
		</div>
	</div>	
	<?php }?>		
			
	<div class="row"> 
		
		<div class="label_wrapper cell bg-non">
			
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			
			
			<?php if(isset($membersData[0]->memberId) && is_numeric($membersData[0]->memberId) && ($membersData[0]->memberId >=1)) {
			
			foreach($membersData as $i=>$data ){ 
				
			    $creative=$data->creative;
				$associatedProfessional=$data->associatedProfessional;
				$enterprise=$data->enterprise;
				
				$receiverName = $data->firstName.' '. $data->lastName;

				$getUserShowcase = showCaseUserDetails($data->tdsUid);
				
				$isShowcaseCreated=true;
				
				if($data->isPublished != 't'){
					$isShowcaseCreated=false;
					$imageType=$this->config->item('defaultMemberImg_xxs');
					$memberType='Member';
				}
				elseif($creative == 't'){
					$imageType=$this->config->item('defaultCreativeImg_xxs');
					$memberType='Creative';
				}elseif($associatedProfessional ==  't'){
					$imageType=$this->config->item('defaultAssProfImg_xxs');
					$memberType='Associated Professional';
					
				}elseif($enterprise == 't'){
					$imageType=$this->config->item('defaultEnterpriseImg_xxs');
					$receiverName = $data->enterpriseName;
					$memberType='Enterprise';
					
				}else{
					$isShowcaseCreated=false;
					$imageType=$this->config->item('defaultMemberImg_xxs');
					$memberType='Member';
					
				}
				
				if($getUserShowcase['userImage']!='') {
				 $userImage=$getUserShowcase['userImage'];
				}
				$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$imageType);  	
				$userImage=getImage($userImage,$imageType);
				
				
				if(!empty($data->accessId) && strlen($data->accessId)>=3){
					$accessId=$data->accessId;
					$accessId=explode('{',$accessId);
					$accessId=$accessId[1];
					$accessId=explode('}',$accessId);
					$accessId=$accessId[0];
					$accessId=explode(',',$accessId);
				}else{
					$accessId=false;
				}
				?>
			<div class="row" id="CG<?php echo $i;?>">									 
			<div id="CGData<?php echo $i;?>" class="cell frm_element_wrapper extract_content_bg width550px">
				<!--extract_img_wp-->
				<div class="extract_img_wp <?php //echo $opacity_4;?>"> 
					<a target="_blank" href="<?php echo base_url(lang().'/showcase/index/'.$data->userId);?>"><img class="formTip ptr maxWH30 ma" src="<?php echo $userImage;?>" /></a>
				</div>
				<!--extract_heading_box-->
				<div class="extract_heading_box width150px"> <?php  echo getSubString($receiverName,50); ?> </div>
				<!--extract_heading_box-->
				<div class="extract_heading_box overflowVisible">
					
					<?php  
					if($userId != $ownerId){
						echo getSubString($data->email,50); 
					}else{
					
						if($ownerId==$data->userId){
							echo '<span class="admin">Admin</span>';
						}
						else{
							?> 
							<div class="mebersAccess">
								<ul>
									<li>
										<a href="javascript:void(0);"><span class="di">
											Access
											<em class="opener-world">
												<img class="di" src="<?php echo base_url('images/zonebar-downarrow.png');?>" alt="dropdown" />
											</em>
										</span></a>
										<ul class="worldsublist">
											<?php
												if(isset($access) && is_array($access) && count($access)>0){
													
													foreach($access as $ac){ 
														$displayLi='';
														if(isset($accessId[0]) && ($accessId[0]==1 || $accessId[0]==11)){
															if($ac->accessId == $accessId[0]){
																$displayLi='';
															}else{
																$displayLi='dn';
															}
														}
														?>
														<li class="<?php echo $displayLi;?>" >
															<div class="row">
																<div class="cell" >
																	<?php 
																	
																		$checked='';
																		if($accessId){
																				if(in_array($ac->accessId, $accessId)){
																					$checked='checked';
																				}
																		}
																		?>
																		<div class="defaultP"><input <?php echo $checked; ?> type="checkbox" class="accessId<?php echo $data->memberId;?>" value="<?php echo $ac->accessId;?>" name="accessId[]" onclick="showHideAccess(this,'<?php echo $data->memberId;?>','<?php echo $ac->key;?>');" ></div>
																		
																</div>
																<div class="cell" ><a href="javascript:void(0);"><?php echo $ac->access;?></div></a>
															</div>
														</li>
														<?php
													}
												}
												if($accessId){
													$memberAccessId=implode(',',$accessId);
												}else{
													$memberAccessId=0;
												}
											?>
											  <input type="hidden" id="memberAccessId<?php echo $data->memberId;?>" value="<?php echo $memberAccessId;?>">
														
											  
											  <li>
												<div class="row">
													<div class="tds-button fl"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit"   type="button" onclick="changeMembersAccess('<?php echo $data->memberId;?>');" ><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div></span></button></div>
													<div class="tds-button fl"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Cancel" name="Cancel" type="button" onclick="cancelAccessChange('<?php echo $data->memberId;?>');" ><span><div class="Fleft">Cancel</div> <div class="icon-cancel-btn-new"></div> </span> </button> </div>
												</div>
											  </li>
											  
										</ul>
									</li>
								</ul>
							</div>
					
							<?php
						}
					}?>
				</div>
				<!--extract_button_box-->
				<?php if($userId==$ownerId){?>
				<div class="extract_button_box">
					<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:removeColMember(<?php echo $data->memberId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
				</div>
				<?php }?>
				
				
			</div>
			<div class="clear"></div>
		</div>
			<?php } }?>
			
			
			
			
		</div><!--from_element_wrapper-->  
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function(){
	   $(".mebersAccess li em").click(function() {
			var hidden = $(this).parents("li").children("ul").is(":hidden");
			
			$(".mebersAccess>ul>li>ul").hide()        
			$(".mebersAccess>ul>li>a").removeClass();
				
				if (hidden) {
					$(this).parents("li").children("ul").toggle();
				} 
		   });
	});
		
	//get sorted user list
	function getUserSortedList() {
		var val =$('#searchSortUser').val();
		if(!val || val =='<?php echo $this->lang->line('keywordSearch'); ?>'){
			val = '';
		}				
		var letter = val;			
			$.ajax
			({     
				type: "POST",
				url: "<?php echo base_url() ?>collaboration/getToadUsers/"+letter,
				
				success: function(msg){ 
					
					$('#userList').html(msg);
					$(".active").removeClass("active");			

					if(val!="#")  { 
					  $("#"+val).addClass("active");
					}
				}
			});			
	}		
	
	//set collaboration member data
	function addCollaborationUser(userId,userName){
		var BASEUrl = "<?php echo base_url();?>";
		var collaboration_id = '<?php echo $collaborationId;?>';						
		$.ajax
		({     
			type: "GET",
			url: BASEUrl+"/collaboration/checkColMember/"+userId+'/'+collaboration_id,
			//data: form_data,
			success: function(data) {
				if(data==true) {
					$('#selectedUserDiv').show();
					$('#member_id').val(userId);
					$('#memberName').html(userName);
					$('#popup_close_btn').parent().trigger('close');
				} else {
					alert(userName+' has already added in collaboration.');
				}
			}
		});		
	}	
	
	//save collaboration member
	function saveCollaborationMember(){
		var BASEUrl = "<?php echo base_url();?>";
		var member_id = $('#member_id').val();
		var collaboration_id = '<?php echo $collaborationId;?>';
		
		//var form_data = {member_id1: member_id,collaboration_id1: collaboration_id};						
		$.ajax
		({     
			type: "GET",
			url: BASEUrl+"/collaboration/saveColMember/"+member_id+'/'+collaboration_id,
			//data: form_data,
			success: function(data) {
				if(data==true) {
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('addedCollaborationMember');?></div>');
				} else {
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('ErrorCollaborationMember');?></div>');
				}
				refreshPge();
			}
		});	
	}	
	
	//remove collaboration member
	function removeColMember(memberId) {
		var confirmRemove = confirm("Are you sure you want to delete?");
		if (confirmRemove == true) {
			var BASEUrl = "<?php echo base_url();?>";						
			$.ajax
			({     
				type: "GET",
				url: BASEUrl+"/collaboration/removeCollaborationMember/"+memberId,
				//data: form_data,
				success: function(data) {
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('removeCollaborationMember');?></div>');
					refreshPge();
				}
			});	
		} else {
			return false;
		}
	}
	
	function changeMembersAccess(memberId){
		var accessId = checkCheckbox('.accessId'+memberId);
		if(accessId){
			var returndata = AJAX_json('<?php echo base_url(lang().'/collaboration/changeMembersAccess');?>','',accessId,memberId,'<?php echo $collaborationId;?>');
			if(returndata){
				
				$('#memberAccessId'+memberId).val(accessId.join(','));
				customAlert('You have successfully changed members access.');
			}
		}else{
			customAlert('Please select atleast one checkox.');
		}
	}
	function cancelAccessChange(memberId){
		var accessId = $('#memberAccessId'+memberId).val().split(',');
		$('.accessId'+memberId).each(function(index){
			var checked = false;
			var value = $(this).val();
			
			if($.inArray(value, accessId)!==-1){
				checked = true;
			}
			$(this).attr("checked", checked);
			
			if(accessId[0]==1 || accessId[0]==11){
				
				if(value == accessId[0]){
					$(this).closest("li").show();
				}else{
					$(this).closest("li").hide();
				}
			}
			
		});
		runTimeCheckBox();
		$('.accessId'+memberId).parents("li").children("ul").toggle();
	}
	
	function showHideAccess(obj, memberId,key){
		if(key=='none' || key=='all' ){
			var checked = false;
			var value = obj.value;
			if(obj.checked){
				 checked = true;
			}
			$('.accessId'+memberId).each(function(index){
				var val = $(this).val();
				if(val != value){
					$(this).attr("checked", false);
					if(checked){
						$(this).closest("li").hide();
					}else{
						$(this).closest("li").show();
					}
				}
			});
			runTimeCheckBox();	
		}
		
	}
	
  </script>

