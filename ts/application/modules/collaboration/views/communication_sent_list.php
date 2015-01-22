<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>                                           
<div class="pr"><div align="center" class ="width_506 pl25 ma load-image" id="load"></div></div>    
    <!--from_element_wrapper-->
    <div class="row seprator_10"></div>
    <div class="row  ">
        <div class="label_wrapper cell bg-non"></div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pl12 pt0">
				<?php            
				$count_sent = count($comSentTmailData); 
				if(is_array($comSentTmailData)){
					$nameString="";
					$status_ids="";
		
					foreach($comSentTmailData as $key => $value):	
								
					$getUserShowcase	= showCaseUserDetails($value['user_id']);
					$userImage=$getUserShowcase['userImage'];
					$creative=$getUserShowcase['creative'];
					$associatedProfessional=$getUserShowcase['associatedProfessional'];
					$enterprise=$getUserShowcase['enterprise'];
					//echo $creative;
					if($enterprise=="t")
					{
						$name= $getUserShowcase['enterpriseName'];
					} else
					{
						$name= $getUserShowcase['userFullName'];
					}
					
					$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
					
					if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');  
					
					if($value['sender_id']==0)
					{
						//$userDefaultImage = base_url('images/default_thumb/toadsquare_default.jpg');
						$userDefaultImage = $this->config->item('defaultToadsquareImg');
						$name = "Toadsquare";
					}
					
					if($value['profileImageName']!='') {
					 $userImage="media/".$value['username']."/profile_image/".$value['profileImageName'];
					  echo $userImage = addThumbFolder($image,'_s');
				    }
				    
					if($value['sender_id']!=0)
					{
						if($getUserShowcase['userImage']!='') {
							$userImage=$getUserShowcase['userImage'];
						}
					}
					 
					$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
					$userImage=getImage($userImage,$userDefaultImage);
			
					$bold=($value['status']==1)? '':'orange_clr_imp';
						///if($nameString=="") {
							$nameString = $name;
						//}				
						?>						  
					<div class="ver_contact_wp parent">
						<a href="<?php echo base_url(lang().'/collaboration/communicationSentTmail/'.$collaborationId.'/'.$value['id'].'/'.$value['user_id']);?>">	
							<div class="ver_contact_user_pic_box">
								<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="center" valign="middle"><img src="<?php echo $userImage ?>" class="max_h_41 max_w_41"  /></td>
									</tr>
								</table>
							</div>
                
							<div class="var_name_wp width_380">
								<div class="var_name <?php echo $bold ?> inboxView">
									<!--Jonathan Livingstone Segal-->
									<?php echo $nameString; ?>
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
					</div><!--ver_contact_wp-->
					<?php endforeach;
				}?>
			</div><!--cell frm_element_wrapper pl12 pt0-->
        </div> <!--row-->
       
		<div class="row">
       		<div class="seprator_15"></div>
			<div class="label_wrapper cell bg-non" style="height:25px;"> </div>
			<!--label_wrapper-->        
			<div class=" cell frm_element_wrapper pt0 width_574" style="min-height:30px;">	
			</div><!--cell frm_element_wrapper pt0 width_574--> 
        </div><!--row-->                
		<div class="clear"></div> 
		
		<!-- Pagination Starts -->
		<div class="row pt3 pl15 pr16">
			<div class="label_wrapper cell bg-non" style="height:25px;"> </div>
			<?php 
			if(isset($countSentTotal) && isset($items_per_page_sent) && $countSentTotal > $items_per_page_sent) {
				$this->load->view('pagination_multi',array("pagination_links"=>$pagination_links_sent,"items_total"=>$items_total_sent,"items_per_page"=>$items_per_page_sent,"url"=>base_url(lang().'/collaboration/communications/'.$collaborationId.'/3'),"divId"=>"showSentTmailData","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper')); ?>
			<?php } ?>	
			<div class="clear"></div>
			<div class="seprator_10"></div>
		</div>
		<!-- Pagination End -->
        
<script type="text/javascript">
 
	$(document).ready(function(){
		selectBox();             		          
		runTimeCheckBox();   				
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
			success: function(msg) { 			
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
