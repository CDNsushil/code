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
		$userImage=addThumbFolder($userImage,$suffix='_s',$thumbFolder ='thumb',$userDefaultImage);  	
		$userImage=getImage($userImage,$userDefaultImage);
	}else{
		$userImage = base_url().'images/var_user_img_default2.jpg';
	}
	//$userImage = base_url().'images/var_user_img_default2.jpg';
?>

<div id="contactContainer" class="contactContainer">
<div class="poup_bx pr50  shadow">
   <div class="close_btn position_absolute " onClick="$(this).parent().trigger('close')"></div>
   <div class="sap_35"></div>
   <div class="fl width_141 mr20 "  >
      <div class="AI_table width104x104 bdr2_ff shadow_large">
         <div class="AI_cell"><img src="<?php echo $userImage;?>" class="width104x104" /></div>
      </div>
      <div class="sap_40"></div>
      <ul class="font_bold fs11 clr_888 listpb15">
         <li> <a >   EMAIL</a></li>
         <li><a >SHOWCASE URL</a></li>
        <?php if((isset($data['0']->phone)) && (!empty($data['0']->phone))){?>
            <li><a >PHONE</a></li>
        <?php } ?>
        <?php if((isset($data['0']->address)) && (!empty($data['0']->address))){ ?>
            <li><a >ADDRESS  </a> </li>
        <?php } ?>
      </ul>
   </div>
   <div class="fl width338 pl36 bl_dfdf ">
      <h2 class="fs24 color_999 font_bold"><?php echo $data['0']->firstName." ".$data['0']->lastName; ?></h2>
      <div class="sap_10"></div>
      <P><?php echo $data['0']->profession; ?></P>
      <div class="sap_35"></div>
      <p><?php echo $data['0']->company; ?></p>
      <div class="sap_35"></div>
      <p><?php echo $data['0']->emailId; ?></p>
      <div class="sap_15  "></div>
        <?php if((isset($data['0']->UserContactId)) && (!empty($data['0']->UserContactId))){ 
            $showcase_url = site_url().lang().'/showcase/aboutme/'.$data['0']->UserContactId;
        ?>
            <p class="WordBreakforLink"><a href="<?php echo site_url().lang().'/showcase/aboutme/'.$data['0']->UserContactId; ?>" target="_blank"  ><?php echo $showcase_url; ?></a></p>
        <?php }?>
        
        <?php if((isset($data['0']->phone)) && (!empty($data['0']->phone))){?>
            <div class="sap_15"></div>
            <p><?php echo $data['0']->phone; ?></p>
        <?php } ?>

        <?php
            if((isset($data['0']->address)) && (!empty($data['0']->address))){ ?>
            <div class="sap_15"></div>
            <p><?php echo $data['0']->address; ?>
            </p>
        <?php } ?>
     
      <div class="sap_35"></div>
      <div class="clearbox contact_btn">
          <!----------------->
            <?php 
            //echo $first_id.$pre."next-".$next;
            
            //echo "next_id-".$next_id."second next-".$second_next;
						
        
        
        if($first_id  == $min_id || $first_id == $max_id){
            if($first_id  == $min_id ) {?>
            <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getpreviousUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
            
                     <a href="javascript:void(0)"  onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $pre.",".$filter; ?>')" class="fl prev_btn">Previous </a>
              <?php
			  }
			  ?>
              
              <?php if($first_id == $max_id ) {?>
                    <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getnextUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
                     <a  href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $next.",".$filter; ?>')" class="fr next_btn">Next </a>
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
                    <a href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo @$prev_id.",".$filter; ?>')" class="fl prev_btn">Previous </a>
                    <?php
						}
					if( count($next) != 0 )
					{
						?>
			          <a  href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $pre.",".$filter; ?>')" class="fr next_btn">Next </a>
					<?php 	
						
				   }
				}       
				
					
					
					elseif($first_id < $pre && $pre == $next)
						{
								
									
							if(count($pre) != 0 ){
					?>	
                        <a href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $prev_id.",".$filter; ?>')" class="fl prev_btn">Previous </a>
                    <?php
						}
					if( count($next) != 0 )
					{
						?>
                        <a  href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo @$n.",".$filter; ?>')" class="fr next_btn">Next </a>
					<?php 	
						
				   }
				}       
					
					
					
					
						
					elseif($first_id > $pre && $first_id < $next)
						{
								
									
							if(count($pre) != 0 ){
					?>	
                                        
                     <a href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $next.",".$filter; ?>')" class="fl prev_btn">Previous </a>
                    <?php
						}
					if( count($next) != 0 )
					{
						?>
						 <a  href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $pre.",".$filter; ?>')" class="fr next_btn">Next </a>
					<?php 	
						
				   }
				}       
				
			      
				
				
				
		else
						{
		
					if(count($pre) != 0 ){
					?>	
                    	<a href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $pre.",".$filter; ?>')" class="fl prev_btn">Previous </a>
                    <?php
						}
					if( count($next) != 0 )
					{
						?>
                            <a  href="javascript:void(0)" onclick="next_prevoius('contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $next.",".$filter; ?>')"  class="fr next_btn">Next </a>
					<?php 	
						
					}
					}
		}	
			    ?>
                
         
      </div>
   </div>
   <!-- End wrap 1  --> 
</div>
</div>
