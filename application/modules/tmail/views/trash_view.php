<?php
$formAttributes = array(
'name'=>'composeForm',
'id'=>'composeForm'
); 

$count_trash = count($user_trash); ?>

                          <div id="countTrash" class="dn">0</div>
                          <div id="recordsTrash" class="dn"><?php echo  $count_trash ?></div>
                          <div id="currentPageTrash" class="dn">1</div>
                          <div id="perPageTrash" class="dn"><?php echo $perPageT ?></div>  


<div class="pr"><div align="center" class ="width_506 pl25 ma load-image" id="loadTrash"></div></div>
<input name="view" id="trash_view" value="trash_view" type="hidden"> 
<div class="row">
          <div class="tab_shadow"> </div>
        </div>
   <input name="view" id="trash_view" value="trash_view" type="hidden">              
          <div class="row  ">
            <div class="label_wrapper cell bg-non">
               
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pl12 pt0">
              <?php 
              $count_trash = count($user_trash);
				if(is_array($user_trash)){
					$nameString="";
					$status_ids="";?>
					<?php foreach($user_trash as $key => $value):
					
					  //print_r($value);
					
					  //$userimage=getImage($value['imagePath'],'userIcon');
					  //$name= $value['firstName'].'&nbsp;'.$value['lastName'] ;
						if($value['is_sender']=="f")
						{
							 $get_sender_id = $value['sender_id'];	
							
						}else
						{
							 $get_sender_id = $value['reciever_id'];	
						}
					
				      $getUserShowcase	= showCaseUserDetails($get_sender_id);
				      $creative=$getUserShowcase['creative'];
					  $associatedProfessional=$getUserShowcase['associatedProfessional'];
					  $enterprise=$getUserShowcase['enterprise'];
				      if($value['sender_id']==0)
						{
							$name = "Toadsquare";
						}else
						{	
							 if($enterprise=="t")
							{
								$name= $getUserShowcase['enterpriseName'];
							}else
							{
								$name =  $getUserShowcase['userFullName'];
							}
						}
					 
					  
					 
					
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
						 
						 
						 if($value['type']==9 || $value['type']==10)
							{
								$url = base_url(lang().'/tmail/viewTmailNew/'.$value['id'].'/Trash');
							}else
							{
								$url = base_url(lang().'/tmail/viewTmail/'.$value['id'].'/Trash');
							} 
						  
						// $url = base_url(lang().'/tmail/viewTmail/'. $value['id'].'/Trash');						 
						 
						 	  ?>
						  
		<a href="<?php echo $url ?>" >					  
              <div class="ver_contact_wp parent">
              	
                 <?php  
                //echo $creative;
                //echo $getUserShowcase['userImage'];
                $userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
				if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');
				//$profile_img = getContactUserProfileImage($value['email']);
				
				if($getUserShowcase['userImage']!='') {
					 $userImage=$getUserShowcase['userImage'];
				    }
				    
				    if($value['sender_id']==0)
					{
						$userImage="";
						$userDefaultImage = $this->config->item('defaultToadsquareImg');
						$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
						$userImage=getImage($userImage,$userDefaultImage);
					}else
					{
						$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
						$userImage=getImage($userImage,$userDefaultImage);
					}
			   ?>
               
				<div class="ver_contact_user_pic_box">
                	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                  <td align="center" valign="middle"><img src="<?php echo $userImage;?>" class="max_h_41 max_w_41"  /></td>
                      </tr>
                    </table>

				
					</div><!--ver_contact_user_pic_box-->
				
                
                
                <div class="var_name_wp"  style="width:303px;">
               			<div class="var_name inboxView">
                        	<!--Jonathan Livingstone Segal-->
                        	<?php echo $nameString ; ?>
                        </div><!--var_name_label-->
                        
                        <div class="var_name font_size11 inboxView">
                        <!--Sample text from subject of Tmail-->
                        <?php echo getSubString($value['subject'],50) ?>
                        </div><!--var_name_label-->
                        
                </div><!--var_name_wp-->
                
                
                <div class="var_datbox_wp">
               	<div class="var_name_label">
                        	Date
                 </div><!--var_name_label-->
                        
                 <div class="var_date_box">
                        <!--24 December 2012-->
                         <?php echo  dateFormatView($value['cdate'],'d M Y') ?>
                </div><!--var_name_label-->
                        
                </div>
       </a>            
                <div class="var_line_divider">
                </div><!--var_line_divider-->
                
                
                <div style="margin-top:7px; " class="tds-button-top">
              <!-- Post Edit Icon -->
              
                <div class="defaultP pr0" >
                      <input type="checkbox" class="caseTrash" name="checkbox[]" id="id_<?php echo $status_ids;?>" value="<?php echo $status_ids;?>" />
                    </div>
               </div><!--defaultP-->
                
              </div><!--ver_contact_wp-->
              
              <?php
						$nameString="";
						$status_ids="";
					}else{
						$nameString=$name;
						$status_ids=$status_id.','.@$user_trash[$key+1]['status'] ;
					}
						endforeach; ?>
					<?php 
				}else{?>
					<?php //echo $label['noRecord']?>
					<?php 
				}?>
             
            </div><!--cell frm_element_wrapper pl12 pt0-->
          </div><!--row-->
          <!--from_element_wrapper-->
          <div class="clear"></div>
      
    
        <!--from_element_wrapper-->
       
       
       <div class="row">
       		<div class="seprator_15"></div>
          <div class="label_wrapper cell bg-non" style="height:25px;"> </div>
          <!--label_wrapper-->
          <div class=" cell frm_element_wrapper pt0 width_574" style="min-height:30px;">
          	
          	 <?php if($countTrash > 0) {?>	
            <div class="tds-button fr">
				
            <button id="DelTmailSent" onclick="showYesNoTrash();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Cancel" name="cancel" type="button" class="dash_link_hover"><span><div class="Fleft">Delete</div> <div class="icon-form-delete-btn"></div></span></button></div>
            <div id="selectallTrash" class="tds-button Fright mr9"> <button type="button"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Select All</div> <div class="icon-save-btn"></div> </span> </button>  </div>
          
          <?php  } ?>
        
         </div>
          
        </div>
        
        <div class="clear"></div>
        
 <!-- Pagination Stars -->
   
 <div class="row pt3 pl15 pr16">
	  <div class="label_wrapper cell bg-non" style="height:25px;"> </div>
	  <?php if(isset($countTrash) && isset($items_per_page_trash) &&  $countTrash > $items_per_page_trash) {?>
	<?php $this->load->view('pagination_multi',array("pagination_links"=>$pagination_links_trash,"items_total"=>$items_total_trash,"items_per_page"=>$items_per_page_trash,"url"=>base_url(lang().'/tmail/trash_view'),"divId"=>"showTrash","formId"=>"composeForm","unqueId"=>"trash","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper')); ?>
	<?php } ?>
	<div class="clear"></div>
	<div class="seprator_10"></div>
</div>
				
 <!-- Pagination End -->       
          
 <script type="text/javascript">

	
	$(document).ready(function(){
			  selectBox();             		          
			   runTimeCheckBox();  
			   
			   $("#selectallTrash").click(function () {						
						  $('.caseTrash').attr('checked', 'checked');
							runTimeCheckBox(); 
					});	
			             
			               
			               
	});		               
			

// DELETE TEMAIL FUNCTIONALITY //

function showYesNoTrash()
{ 
	var n = $("input:checked").length;
	
	if(n>0){
		$("#YesNoBoxWpTrash").lightbox_me('center:true');
	}else{
		alert('<?php echo $this->lang->line('checkMsgAlert') ?>');
		return false;
	}
}


function deleteSentTrash(confirmflag){
	if(confirmflag=='t'){
		deletTmailTrash();
		$(this).parent().trigger('close');
		//$('#YesNoBoxWp').trigger('close');
	}
	else{
		$('#YesNoBoxWpTrash').trigger('close');	
	}			
}




  function deletTmailTrash(){  	    
									 
			var limit = parseInt($("#perPageTrash").html());
			var offSet = parseInt($('#countTrash').html());
			var currentPage = parseInt($('#currentPageTrash').html());			
						
			var val = [];
				 $(':checkbox:checked').each(function(i){
						  val[i] = $(this).val();
						  
					});					
					
					
					$.ajax
						({     
							type: "POST",
							url: "<?php echo base_url() ?>tmail/trashTmailMessage/"+val+'/'+limit+'/'+offSet+'/Trash/'+currentPage,
																		
							success: function(msg)
									{ 			
										$('#YesNoBoxWpTrash').trigger('close');														
										$('#showTrash').html(msg);
											
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
