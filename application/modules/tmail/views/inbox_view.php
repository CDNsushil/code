<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$formAttributes = array(
'name'=>'composeForm',
'id'=>'composeForm'
); 

$count_inbox = count($user_inbox); ?>

<div id="countI" class="dn">0</div>
<div id="records" class="dn"><?php echo $count_inbox ?></div>
<div id="currentPage" class="dn">1</div>
<div id="perPageInbox" class="dn"><?php echo $perPage ?></div>

                                                    
<div class="pr"><div align="center" class ="width_506 pl25 ma load-image" id="load"></div></div>
       <div class="row">
          <div class="tab_shadow"> </div>
       </div>
        
  
 
 <?php echo form_open($this->uri->uri_string()."/compose",$formAttributes); ?>   
 <input name="view" id="view" value="inbox_view" type="hidden">
  
 <?php echo form_close(); ?>       
        
        <!--from_element_wrapper-->
        
        <div class="row seprator_10"></div>
      
          <div class="row  ">
            <div class="label_wrapper cell bg-non">
              
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pl12 pt0">
              <?php            
              
				$count_inbox = count($user_inbox); 
				if(is_array($user_inbox)){
					$nameString="";
					$status_ids="";?>
					<?php foreach($user_inbox as $key => $value):				
					//print_r($value);
					$userImage=$value['image'];
					$creative=$value['creative'];
					$associatedProfessional=$value['associatedProfessional'];
					$enterprise=$value['enterprise'];
					//echo $creative;
					if($enterprise=="t")
					{
						$name= $value['enterpriseName'];
					}else
					{
						$name= $value['firstName'].'&nbsp;'.$value['lastName'] ;
					}
					
					$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
					
					if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m'); 
					//echo $value['profileImageName'];   
					
					if($value['sender_id']==0)
					{
						//$userDefaultImage = base_url('images/default_thumb/toadsquare_default.jpg');
						$userDefaultImage = $this->config->item('defaultToadsquareImg');
						$name = "Toadsquare";
					}
					
					if($value['profileImageName']!='') {
					 $userImage="media/".$value['username']."/profile_image/".$value['profileImageName'];
					  //echo $userImage = addThumbFolder($image,'_s');
				    }
				    
					
					if($value['sender_id']!=0)
					{
						$getUserShowcase	= showCaseUserDetails($value['sender_id']);
						if($getUserShowcase['userImage']!='') {
							$userImage=$getUserShowcase['userImage'];
						}
					}
					
					
				    //echo $userImage; 
					$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
					$userImage=getImage($userImage,$userDefaultImage);
					
					
					
					
						
					/*$profile_img = getContactUserProfileImage($value['email']);	
						
						if($profile_img!='')
                           $userImage = base_url().$profile_img['ContactUserProfileImage'] ; */                           
                         
                         
					
					$status_id=$value['status_id'];
					$bold="";
					 if($tmailHeading=='Inbox'){
						$bold=($value['status']==1)? '':'orange_clr_imp';
					  }
					  if($value['id'] != ''){
						  if($nameString==""){
							$nameString=$name;
							$status_ids=$status_id;
						  }
						  
						 // echo $value['id'];
						 //$functionLgtBox = "openLightBox('popupBoxWp','popup_box','/tmail/showTmailPopup/".$value['id']."/Inbox')";
						 $functionLgtBox = "";
						 
						if($value['type']==9 || $value['type']==10)
							{
								$url = base_url(lang().'/tmail/viewTmailNew/'.$value['id'].'/Inbox');
							}else
							{
								$url = base_url(lang().'/tmail/viewTmail/'.$value['id'].'/Inbox');
							}
						 if($value['type']==2)
						 $functionLgtBox = "openLightBox('popupBoxWp','popup_box','/tmail/showTmailReplay/".$value['id']."/Inbox')";
						
						 
						  
				?>
						  
					  
              <div class="ver_contact_wp parent">
              	<a href="<?php echo $url ?>" onclick="<?php //echo  $functionLgtBox; ?>">	
                <div class="ver_contact_user_pic_box">
                	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
						<td align="center" valign="middle"><img src="<?php echo $userImage ?>" class="max_h_41 max_w_41"  /></td>
                      </tr>
                    </table>
				</div>
                
                <div class="var_name_wp"  style="width:303px;">
               			<div class="var_name <?php echo $bold ?> inboxView">
                        	<!--Jonathan Livingstone Segal-->
                        	<?php echo $nameString ; ?>
                        </div><!--var_name_label-->
                        
                        <div class="var_name  <?php echo $bold ?> font_size11 inboxView">
                        <!--Sample text from subject of Tmail-->
                        <?php echo getSubString($value['subject'],50) ?>
                        </div><!--var_name_label-->
                        
                </div><!--var_name_wp-->
                
                
                <div class="var_datbox_wp">
               	<div class="var_name_label">
                    <?php echo $this->lang->line('Date');?>
                </div><!--var_name_label-->
                        
                 <div class="var_date_box">
                    <?php echo  dateFormatView($value['cdate'],'d M Y') ?>                        
                </div><!--var_name_label-->
                        
                </div>
         </a>  
                <div class="var_line_divider">
                </div><!--var_line_divider-->
                
                
                <div style="margin-top:7px; " class="tds-button-top">
              <!-- Post Edit Icon -->
              
                <div class="defaultP pr0" >
                      <input type="checkbox" class="case" name="checkbox[]" id="id_<?php echo $status_ids;?>" value="<?php echo $status_ids;?>" />
                    </div>
               </div><!--defaultP-->
                
              </div><!--ver_contact_wp-->
              
              <?php
						$nameString="";
						$status_ids="";
					}else{
						$nameString=$name ;
						$status_ids=$status_id.','.@$user_inbox[$key+1]['status'] ;
					}
						endforeach; ?>
					<?php 
				}else{?>
					<?php //echo $label['noRecord']?>
					<?php 
				}?>
      
				</div><!--cell frm_element_wrapper pl12 pt0-->
            </div> <!--row-->
        <!--from_element_wrapper
   <a id="nextButton" class="buttons next mr2 nextButton" href="javascript://void(0);">Next</a>    -->
       
       <div class="row">
       		<div class="seprator_15"></div>
          <div class="label_wrapper cell bg-non" style="height:25px;"> </div>
          <!--label_wrapper-->
          
          
          <div class=" cell frm_element_wrapper pt0 width_574" style="min-height:30px;">
          		
          	  <?php if($countInbox > 0) {?>
          	  	
            <div class="tds-button fr"> 
           
            <button id="DelTmail" onclick="showYesNo();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Cancel" name="cancel" type="button" class="dash_link_hover"><span><div class="Fleft">Delete</div> <div class="icon-form-delete-btn"></div></span></button></div>
            <div id="selectall" class="tds-button Fright mr9"> <button type="button"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Select All</div> <div class="icon-save-btn"></div> </span> </button>  </div>
          
         
		<?php } ?>
          </div><!--cell frm_element_wrapper pt0 width_574-->
          
        </div><!--row-->
      
       
        
                
   <div class="clear"></div> 
   
 <!-- Pagination Starts -->
 
	<div class="row pt3 pl15 pr16">
	  <div class="label_wrapper cell bg-non" style="height:25px;"> </div>
	 <?php if(isset($countInbox) && isset($items_per_page) && $countInbox > $items_per_page) {?>
	  <?php $this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/tmail/inbox_view'),"divId"=>"showInbox","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper')); ?>
	 <?php } ?>	
	  <div class="clear"></div>
	  <div class="seprator_10"></div>
	</div>
				
<!-- Pagination End -->
        
<script type="text/javascript">
 
$(document).ready(function(){
	selectBox();             		          
	runTimeCheckBox();   
				
	$("#selectall").click(function () {					
	  $('.case').attr('checked', 'checked');
		runTimeCheckBox(); 
	  });	 				
					
});					
					

// DELETE TEMAIL FUNCTIONALITY //

function showYesNo()
{ 
	var n = $("input:checked").length;
	
	if(n>0){
		$("#YesNoBoxWp").lightbox_me('center:true');
	}else{
		alert('<?php echo $this->lang->line('checkMsgAlert') ?>');
		return false;
	}
}

function noGallery(){
	
	$('#YesNoBoxWp').trigger('close');	
}


function deleteInboxTmail(confirmflag){
	
	if(confirmflag=='t'){
		deletTmail();
		$(this).parent().trigger('close');
		//$('#YesNoBoxWp').trigger('close');
	}
	else{
		$('#YesNoBoxWp').trigger('close');	
	}			
}




  function deletTmail(){  	    
									 
			var limit = parseInt($("#perPageInbox").html());
			var offSet = parseInt($('#countI').html());
			var currentPage = parseInt($('#currentPage').html());			
						
			var val = [];
				 $(':checkbox:checked').each(function(i){
						  val[i] = $(this).val();
						  
					});				
					
					
					$.ajax
						({     
							type: "POST",
							url: "<?php echo base_url() ?>tmail/trashTmailMessage/"+val+'/'+limit+'/'+offSet+'/Inbox/'+currentPage,
																		
							success: function(msg)
									{ 			
										$('#YesNoBoxWp').trigger('close');														
										$('#showInbox').html(msg);
											
										//location.reload();										
									}

					});					
				           			          
		         runTimeCheckBox();          
			 
		  }         
	               

// END 

/* Function for change color on hover*/
$('.parent').hover(function(){
	$(this).find('.inboxView').toggleClass('orange_clr_imp')
});
  	
</script>
