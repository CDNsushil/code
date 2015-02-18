<div class=" cell frm_element_wrapper pl12 ">
	<div id="pagingContent">
		<?php $count = 0; 
		//echo "<pre>";
		//print_r($contactList);
		//die;
		if(!empty($contactList)) {
			foreach($contactList as $value){
				$cont_id[] = $value->contId;	
			}
			$comma_separated = implode(",", $cont_id);
			$count=count($contactList);
			foreach($contactList as $contacs) { ?>
				<div class="all_list_item">
					<div class="hover_parent_contact">
					<div class="ver_contact_wp" style="cursor:pointer;" id="<?php echo $contacs->contId;?>">
					<!-- Get Users Profile image start-->
					<?php 
					$getUserShowcase = showCaseUserDetails($contacs->UserContactId);
					if(isset($contacs->UserContactId) && !empty($contacs->UserContactId))
					{
						$creative=$getUserShowcase['creative'];
						$associatedProfessional=$getUserShowcase['associatedProfessional'];
						$enterprise=$getUserShowcase['enterprise'];
						$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
						if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');
						//$profile_img = getContactUserProfileImage($value['email']);
						if($getUserShowcase['userImage']!='') {
							 $userImage=$getUserShowcase['userImage'];
						}
						//echo $userImage;
						$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
						$userImage=getImage($userImage,$userDefaultImage);
						$userShowcaseUrl = base_url().'showcase/index/'.$contacs->UserContactId;
					}else{
						$userImage = base_url().'images/var_user_img_default2.jpg';
						$userShowcaseUrl = 'javascript::void(0)';
					}
					//$userImage = base_url().'images/var_user_img_default2.jpg';
				?>
				<!-- Get Users Profile image end-->
							<div class="ver_contact_user_pic_box">
								<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="center" valign="middle"><a href="<?php echo $userShowcaseUrl;?>"><img src="<?php echo $userImage ;?>" class="max_h_41 max_w_41"  /></a></td>
									</tr>
								</table>
							</div><!--ver_contact_user_pic_box-->
						<div class="var_name_wp" onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $contacs->contId.",".$comma_separated; ?>')">
							<div class="var_name_label">First Name</div><!--var_name_label-->                        
							<div class="var_name_contact"><?php echo $contacs->firstName;?></div><!--var_name_label-->                        
						</div><!--var_name_wp--> 

						<div class="var_lastname_wp" onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $contacs->contId.",".$comma_separated;?>')">
							<div class="var_name_label">Last Name</div><!--var_name_label-->                        
							<div class="var_name_contact"><?php if($contacs->lastName !=''){ echo $contacs->lastName;}else {echo '&nbsp;';} ?></div><!--var_name_label-->                        
						</div><!--var_name_wp--> 

						<div class="var_mail_wp" onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $contacs->contId.",".$comma_separated; ?>')">
							<div class="var_name_label">Email</div><!--var_name_label-->                        
							<div class="var_name_contact"><?php echo $contacs->emailId;?></div><!--var_name_label-->                        
						</div><!--var_name_wp--> 

						<div class="var_line_divider"></div><!--var_line_divider-->                

						<div class="tds-button-top" style="margin-top:7px; margin-right:3px;">
							<?php
							$contId = $contacs->contId;
							$editArr = array('title'=>'edit',
							'class'=>"formTip contId mr6",
							'id'=>"contId", 
							'firstName'=>$contacs->firstName, 
							'lastName'=> $contacs->lastName, 
							'emailId'=>$contacs->emailId, 
							'profession'=>$contacs->profession, 
							'company'=> $contacs->company, 
							'toadsquareUrl'=> $contacs->toadsquareUrl, 
							'address'=> $contacs->address, 
							'phone'=>$contacs->phone,
							"onclick"=>"populate(this)",
							'contId'=>$contacs->contId
							);
							echo anchor('javascript://void(0);', '<span><div class="projectEditIcon"></div></span>',$editArr);

							$attr = array("title"=>'delete',"class"=>'formTip mr6',"onclick"=>"deleteRecord('".$contacs->contId."')");

							echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);
							?>
						</div>
					</div><!--ver_contact_wp-->
					</div>
				</div><!--all_list_item-->
				<?php 
			} 
		}
		else { 
		//echo "<div align='center'>No record found</div> ";
		}
		?>                
	</div><!--pagingContent-->                	
</div><!-- cell frm_element_wrapper pl12 -->


<input type="hidden" name="idToDelete" id='idToDelete' value="0" />
<div class="row">
	<div class="label_wrapper cell bg-non" style="height:25px"> </div>
	<?php
	if($count >  $this->lang->line('perPageRecord')){?>
		<div class=" cell frm_element_wrapper pl12 pt0 width_579 "  style="min-height:32px">
			<div class="row mt25 mb25 mH25" style="min-height:30px">
				<?php
				$this->load->view('pagination_view',array('totalRecord'=>$count,'record_num'=>$this->lang->line('perPageRecord')));
				?>
			</div>
		</div>
		<?php
	}?>
</div>
<div class="clear"></div>

