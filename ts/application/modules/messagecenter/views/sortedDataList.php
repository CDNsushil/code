<div class="vcard_popup_wp">
     
<?php  
 //print_r($filter);
    
   $id_separated = explode(",", $filter);
  
   $id_separated1 = explode(",", $filter);
  
  
  @$c =   $data['0']->contId;
  
  unset($id_separated1['0']);
  
  @$key = array_search($c,$id_separated1); 
  
 
  function getPrevNext($haystack,$needle) {
    $prev = $next = null;

    $aKeys = array_keys($haystack);
    $k = array_search($needle,$aKeys);
    if ($k !== false) {
        if ($k > 0)
            $prev = array($aKeys[$k-1] => $haystack[$aKeys[$k-1]]);
        if ($k < count($aKeys)-1)
            $next = array($aKeys[$k+1] => $haystack[$aKeys[$k+1]]);
    }
    return array($prev,$next);
}



  @$a = getPrevNext($id_separated,$key);
    //print_r($a);

foreach($a as $num)
{
	//print_r($num);
	if(!empty($num)){
		foreach($num as $key=>$num2)
		{
		 
		@$arrr[] =  $num[$key];
				
		}
	}
}


@$pre = $arrr['0'];

@$next =   $arrr['1'];
  
  
  //echo $key;
  
   
  
  //echo array_search($data['0']->contId, $id_separated);
   
    $max_id =   max($id_separated);
   
 $min_id =   min($id_separated); 
   
  //print_r($id_separated);

 $next_id =    next($id_separated);
 
 
 
 $second_next = next($id_separated);
 

 $first_id =  array_shift($id_separated); 
  //echo  count($id_separated);

 
 
 $end_id =   end($id_separated);
 
  //echo  array_shift($id_separated);
  ?>
 <!-- Get Users Profile image start-->
	<?php
	$getUserShowcase = showCaseUserDetails($data['0']->UserContactId);
	if(isset($data['0']->UserContactId) && !empty($data['0']->UserContactId))
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
	}else{
		$userImage = base_url().'images/var_user_img_default2.jpg';
	}
	//$userImage = base_url().'images/var_user_img_default2.jpg';
?>
				<!-- Get Users Profile image end-->  
<div class="vcard_popup_left">
        
        
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="middle">
                <img src="<?php echo $userImage;?>" class="max_h_104 max_w_104" />
                </td>
              </tr>
            </table>
	        	        	
        </div><!--vacard_popup_left-->
        
        <div class="vcard_popup_right">
        	<div class="vcard_popup_name"><?php echo $data['0']->firstName." ".$data['0']->lastName; ?></div><!--vcard_popup_right-->
            
            <div class="vcard_popup_occup"><?php echo $data['0']->profession; ?></div>
            
            <div class="vcard_popup_com_name"><?php echo $data['0']->company; ?></div>
            
           <div class="vcard_email_label"> Email</div>   <div class="vcard_email_box"><?php echo $data['0']->emailId; ?></div>
           
           <div class="row seprator_15"></div>
            <?php if((isset($data['0']->UserContactId)) && (!empty($data['0']->UserContactId))){ 
				$showcase_url = site_url().lang().'/showcase/aboutme/'.$data['0']->UserContactId;
				?>
            <div class="vcard_email_label">Showcase URL</div>   <div class="vcard_email_box">
				<a href="<?php echo site_url().lang().'/showcase/aboutme/'.$data['0']->UserContactId; ?>" target="_blank" class="white dash_link_hover" ><?php echo $showcase_url; ?></a>
			<div class="row seprator_15"></div>
				<?php //echo $data['0']->toadsquareUrl; ?></div>
            <?php }?>
            
            <?php if((isset($data['0']->phone)) && (!empty($data['0']->phone))){?>
            <div class="vcard_email_label">Phone </div>    <div class="vcard_email_box"><?php echo $data['0']->phone; ?></div>
            
            <div class="row seprator_15"></div>
            <?php }
            if((isset($data['0']->address)) && (!empty($data['0']->address))){ ?>
            <div class="vcard_email_label"> Address</div>   
				<div class="vcard_email_box"><?php echo $data['0']->address; ?>
            </div>
            <?php } ?>
            <div class="clear"></div>
            <div class="vcard_next_pre_wp">
           <!----------------->
        

           <!----------------->
            <?php 
            //echo $first_id.$pre."next-".$next;
            
            //echo "next_id-".$next_id."second next-".$second_next;
						
        
        
        if($first_id  == $min_id || $first_id == $max_id){
            if($first_id  == $min_id ) {?>
            <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getpreviousUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
            
            <div class="vcard_pre_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $pre.",".$filter; ?>')">
                    	<div class="cell mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_pre_arrow.jpg"/></div>
                        <div class="cell ml7 org_anchor_hover"><a style="cursor: pointer;">Previous</a></div>
                   
                   
                    </div><!--vcard_pre_box-->
              <?php
			  }
			  ?>
              
              <?php if($first_id == $max_id ) {?>
                    <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getnextUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
                    <div class="vcard_next_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $next.",".$filter; ?>')">
                    	 <div class="cell org_anchor_hover"><a style="cursor: pointer;">Next</a></div>
                         <div class="cell ml7 mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_next_arrow.jpg"/></div>
                   
                    </div><!--vcard_next_box-->
                    <?php
				}
			}
			
					
					
			
				else
				{
					@$prev_id =    prev($id_separated);
					@$prev_id =    prev($id_separated);
					@$prev_id =    prev($id_separated);
					
					 @$n = next($id_separated);
					 @$n = next($id_separated);
					 @$n = next($id_separated);
					
					
					if($first_id > $pre && $pre == $next)
						{
								
									
							if(count($pre) != 0 ){
					?>	
                    <div class="vcard_pre_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo @$prev_id.",".$filter; ?>')">
                    	<div class="cell mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_pre_arrow.jpg"/></div>
                        <div class="cell ml7 org_anchor_hover"><a style="cursor: pointer;">Previous</a></div>
                   
                   
                    </div><!--vcard_pre_box-->
                    <?php
						}
					if( count($next) != 0 )
					{
						?>
						<div class="vcard_next_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $pre.",".$filter; ?>')">
                    	 <div class="cell org_anchor_hover"><a style="cursor: pointer;">Next</a></div>
                         <div class="cell ml7 mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_next_arrow.jpg"/></div>
                   
                    </div><!--vcard_next_box-->
					<?php 	
						
				   }
				}       
				
					
					
					elseif($first_id < $pre && $pre == $next)
						{
								
									
							if(count($pre) != 0 ){
					?>	
                    <div class="vcard_pre_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $prev_id.",".$filter; ?>')">
                    	<div class="cell mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_pre_arrow.jpg"/></div>
                        <div class="cell ml7 org_anchor_hover"><a style="cursor: pointer;">Previous</a></div>
                   
                   
                    </div><!--vcard_pre_box-->
                    <?php
						}
					if( count($next) != 0 )
					{
						?>
						<div class="vcard_next_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo @$n.",".$filter; ?>')">
                    	 <div class="cell org_anchor_hover"><a style="cursor: pointer;">Next</a></div>
                         <div class="cell ml7 mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_next_arrow.jpg"/></div>
                   
                    </div><!--vcard_next_box-->
					<?php 	
						
				   }
				}       
					
					
					
					
						
					elseif($first_id > $pre && $first_id < $next)
						{
								
									
							if(count($pre) != 0 ){
					?>	
                    <div class="vcard_pre_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $next.",".$filter; ?>')">
                    	<div class="cell mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_pre_arrow.jpg"/></div>
                        <div class="cell ml7 org_anchor_hover"><a style="cursor: pointer;">Previous</a></div>
                   
                   
                    </div><!--vcard_pre_box-->
                    <?php
						}
					if( count($next) != 0 )
					{
						?>
						<div class="vcard_next_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $pre.",".$filter; ?>')">
                    	 <div class="cell org_anchor_hover"><a style="cursor: pointer;">Next</a></div>
                         <div class="cell ml7 mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_next_arrow.jpg"/></div>
                   
                    </div><!--vcard_next_box-->
					<?php 	
						
				   }
				}       
				
			      
				
				
				
		else
						{
		
					if(count($pre) != 0 ){
					?>	
                    <div class="vcard_pre_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $pre.",".$filter; ?>')">
                    	<div class="cell mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_pre_arrow.jpg"/></div>
                        <div class="cell ml7 org_anchor_hover"><a style="cursor: pointer;">Previous</a></div>
                   
                   
                    </div><!--vcard_pre_box-->
                    <?php
						}
					if( count($next) != 0 )
					{
						?>
						<div class="vcard_next_box" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $next.",".$filter; ?>')">
                    	 <div class="cell org_anchor_hover"><a style="cursor: pointer;">Next</a></div>
                         <div class="cell ml7 mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_next_arrow.jpg"/></div>
                   
                    </div><!--vcard_next_box-->
					<?php 	
						
					}
					}
		}	
			    ?>
            </div><!--vcard_next_pre_wp-->                                                
                                                            
        </div><!--vcard_popup_right-->
       
       <div class="clear"></div> 
</div><!--vcard-popup_wp-->
