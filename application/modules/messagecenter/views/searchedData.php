
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
				
                    <div  style="cursor:pointer;" id="<?php echo $contacs->contId;?>">
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
					 <!-- start wrap 1  -->
                            <div class="fl tmail_notice ">
                                <a href="<?php echo $userShowcaseUrl;?>">
                                   <div class=" display_table fl notice_thumb">
                                        <div class="table_cell"> <img alt="" src="<?php echo $userImage ;?>"> </div>
                                   </div>
                               </a>
                               <div class="fl fs13  pl15 pr15">
                                  <ul class="tmail_inner">
                                     <li class="width80"><label> First Name</label>
                                        <?php echo $contacs->firstName;?>
                                     </li>
                                     <li class="width80"> <label> Last Name</label>	
                                        <?php if($contacs->lastName !=''){ echo $contacs->lastName;}else {echo '&nbsp;';} ?>	
                                     </li>
                                     <li class="width205"><label> Email  </label> 
                                        <?php echo $contacs->emailId;?>
                                     </li>
                                     <li class="fs13 edit_nav width44">
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
                                            'contId'=>$contacs->contId,
                                            'userBusinessName'=>$contacs->userBusinessName,
                                            );
                                            echo anchor('javascript://void(0);', 'Edit',$editArr);

                                            $attr = array("title"=>'delete',"class"=>'formTip mr6',"onclick"=>"deleteRecord('".$contacs->contId."')");

                                            echo anchor('javascript://void(0);','Delete',$attr);
                                            ?>
                             
                                        <a href="javascript:void(0)"  onclick="openLightBox('popupBoxWp','popup_box','/messagecenter/getUserContactDetail_forsearch/<?php echo $contacs->contId.",".$comma_separated; ?>')">View</a>
                                     </li>
                                  </ul>
                               </div>
                            </div>
                        <!-- End wrap 1  --> 
                    
                    </div>
				<?php 
			} 
		}
		else { 
		//echo "<div align='center'>No record found</div> ";
		}
		?>                

<input type="hidden" name="idToDelete" id='idToDelete' value="0" />

 <div class="sap_60"></div>
    <?php
    $url =base_url_lang("messagecenter/contacts");
    if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
         <div class="row">
                <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$url,"divId"=>"sorted_data","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
            <div class="clear"></div>
        </div>
    <?php } ?>


