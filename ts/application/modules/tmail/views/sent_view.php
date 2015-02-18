<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'composeForm',
'id'=>'composeForm'
); 

$count_sent = count($user_sent); ?>

<div id="countSent" class="dn">0</div>
<div id="recordsSent" class="dn"><?php echo $count_sent ?></div>
<div id="currentPageSent" class="dn">1</div>
<div id="perPageSent" class="dn"><?php echo $perPageS ?></div>

<div class="row">
  <div class="tab_shadow"> </div>
</div>
       
        
    <input name="view" id="sent_view" value="sent_view" type="hidden">   
        
      <div class="row  ">
            <div class="label_wrapper cell bg-non">
               
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pl12 pt0">
				
				<?php
				$count_sent = count($user_sent); 
				if(is_array($user_sent)){
					$nameString="";
					$status_ids="";?>
					<?php foreach($user_sent as $key => $value):
					//print_r($value);
					$reciever_id = $value['reciever_id'];	
					  //$userimage=getImage($value['imagePath'],'userIcon');
					 // $name= $value['firstName'].'&nbsp;'.$value['lastName'] ;
					$getUserShowcase	= showCaseUserDetails($reciever_id);
					
					
					$creative=$getUserShowcase['creative'];
					$associatedProfessional=$getUserShowcase['associatedProfessional'];
					$enterprise=$getUserShowcase['enterprise'];
					
					if($enterprise=="t")
					{
						$name= $getUserShowcase['enterpriseName'];
					}else
					{
						$name =  $getUserShowcase['userFullName'];
					}
					
					
					$status_id=$value['status_id'];
					$bold="";
					 if($tmailHeading=='Inbox'){
						$bold=($value['status']==1)? '':'orange_clr_imp';
					  }
					  if($value['id'] !=''){
						  if($nameString==""){
							$nameString=$name;
							$status_ids=$status_id;
						  }
					  
				$url = base_url(lang().'/tmail/viewTmail/'. $value['id'].'/Sent');
				
			//print_r($getUserShowcase);	
			
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
				//echo $userImage;
				$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
				$userImage=getImage($userImage,$userDefaultImage);
					
               ?>
				<div class="ver_contact_user_pic_box">
                	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
							<td align="center" valign="middle"><img src="<?php echo $userImage;?>" class="max_h_41 max_w_41"  /></td>
						</tr>
                    </table>
				</div><!-- ver_contact_user_pic_box -->
				
                <div class="var_name_wp"  style="width:303px;">
               			<div class="var_name inboxView">                        
                        	<?php echo $nameString ; ?>
                        </div><!--var_name_label-->
                        
                        <div class="var_name font_size11 inboxView">                       
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
            <div class="var_line_divider"></div><!--var_line_divider-->
            <div style="margin-top:7px; " class="tds-button-top">               
                <div class="defaultP pr0" >
                      <input type="checkbox" class="caseSent" name="checkbox[]" id="id_<?php echo $status_ids;?>" value="<?php echo $status_ids;?>" />
                </div>
               </div><!-- button -->                
           </div><!--ver_contact_wp-->
              
              <?php
						$nameString="";
						$status_ids="";
					}else{
						$nameString=$name.',&nbsp;'.@$user_sent[$key+1]['firstName'].'&nbsp;'.$user_sent[$key+1]['lastName'] ;
						$status_ids=$status_id.','.@$user_sent[$key+1]['status'] ;
					}
						endforeach; ?>
					<?php 
				}else{?>
					<?php //echo $label['noRecord']?>
					<?php 
				}?>
				
				
             </div><!--cell frm_element_wrapper pl12 pt0-->
            </div> <!--row-->
             
         <!-- Sent Mail view comes here-->
       
    
        <!--from_element_wrapper-->
       
       
       <div class="row">
       		<div class="seprator_15"></div>
          <div style="height:25px;" class="label_wrapper cell bg-non"> </div>
          <!--label_wrapper-->
          <div style="min-height:30px;" class=" cell frm_element_wrapper width_574 pt0">
          		
         <?php if($countSent > 0) {?>
            <div class="tds-button fr">
		    <button id="DelTmailSent" onclick="showYesNoSent();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Cancel" name="cancel" type="button" class="dash_link_hover"><span><div class="Fleft">Delete</div> <div class="icon-form-delete-btn"></div></span></button></div>
            <div id="selectallSent" class="tds-button Fright mr9"> <button type="button"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Select All</div> <div class="icon-save-btn"></div> </span> </button>  </div>
			
          
          <?php } ?>
          
          </div>
          
        </div>
        
        <div class="clear"></div>
        
  <!-- Pagination Starts -->
       
 <div class="row pt3 pl15 pr16">
	  <div class="label_wrapper cell bg-non" style="height:25px;"> </div>
	   <?php if(isset($countSent) && isset($items_per_page_sent)  && $countSent > $items_per_page_sent) {?>
	  <?php $this->load->view('pagination_multi',array("pagination_links"=>$pagination_links_sent,"items_total"=>$items_total_sent,"items_per_page"=>$items_per_page_sent,"url"=>base_url(lang().'/tmail/sent_view'),"divId"=>"showSent","formId"=>"composeForm","unqueId"=>"sent","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper')); ?>
		<?php } ?>
	  <div class="clear"></div>
	 <div class="seprator_10"></div>
</div>
				 
 <!-- Pagination End -->       
   
        
        
 <script type="text/javascript">

	
	$(document).ready(function(){
			selectBox();             		          
			runTimeCheckBox();
			  
			  $("#selectallSent").click(function () {						
						  $('.caseSent').attr('checked', 'checked');
							runTimeCheckBox(); 
					});	   
			               
	});		               
	
	
// DELETE TEMAIL FUNCTIONALITY //

function showYesNoSent()
{ 
	var n = $("input:checked").length;
	
	if(n>0){
		$("#YesNoBoxWpSent").lightbox_me('center:true');
	}else{
		alert('<?php echo $this->lang->line('checkMsgAlert') ?>');
		return false;
	}
}

function noGallerySent(){
	
	$('#YesNoBoxWpSent').trigger('close');	
}


function deleteSentMail(confirmflag){
	if(confirmflag=='t'){
		deletSentTmail();
		$('#YesNoBoxWpSent').trigger('close');
	}
	else{
		$('#YesNoBoxWpSent').trigger('close');	
	}			
}




  function deletSentTmail(){  	    
									 
			var limit = parseInt($("#perPageSent").html()); 
			var offSet = parseInt($('#countSent').html());
			var currentPage = parseInt($('#currentPage').html());
			var val = [];
				 $(':checkbox:checked').each(function(i){
						  val[i] = $(this).val();
						  
					});					
					
					
					$.ajax
						({     
							type: "POST",
							url: "<?php echo base_url() ?>tmail/trashTmailMessage/"+val+'/'+limit+'/'+offSet+'/Sent/'+currentPage,
																		
							success: function(msg)
									{ 			
										$('#YesNoBoxWpSent').trigger('close');															
										$('#showSent').html(msg);	
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
