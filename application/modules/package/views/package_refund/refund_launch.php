<div id="divCounter<?php echo $divCounter; ?>" class="<?php echo ($divCounter=="1")?'':'dn'; ?>">

  <h3 class="red  fs21 fnt_mouse bb_aeaeae"><?php echo $this->lang->line('pack_refund_launch_heading'); ?></h3>

  <?php 
    if(!empty($projectDataList)) { 
    
    foreach($projectDataList as $projectdata){
      
      //get industry type for showing
      $containerType               =  (!empty($projectdata['containertype']))?$projectdata['containertype']:'0';
      
      //check industry type for section
      if($containerType==$sectionname){
        
      $userContainerId            =  (!empty($projectdata['userContainerId']))?$projectdata['userContainerId']:'0';
      $projectId                  =  (!empty($projectdata['elementId']))?$projectdata['elementId']:'0';
      $projectTitle               =  (!empty($projectdata['lunchtitle']))?$projectdata['lunchtitle']:'';
      $viewCount                  =  (isset($projectdata['viewCount']))?$projectdata['viewCount']:'0';
      $craveCount                 =  (isset($projectdata['craveCount']))?$projectdata['craveCount']:'0';
      $reviewCount                =  (isset($projectdata['craveCount']))?$projectdata['reviewCount']:'0';
      $ratingAvg                  =  (isset($projectdata['ratingAvg']))?$projectdata['ratingAvg']:'0';
      $startDate                  =  (!empty($projectdata['LaunchEventCreated']))?$projectdata['LaunchEventCreated']:'';
      $userDefaultTsProductId     =  (isset($projectdata['userDefaultTsProductId']))?$projectdata['userDefaultTsProductId']:'0';
      $countryName                =  (!empty($projectdata['countryName']))?$projectdata['countryName']:'None';
      $type                       =  (isset($projectdata['launchtype']))?$projectdata['launchtype']:'0';
      $IndustryId                 =  (!empty($projectdata['IndustryId']))?$projectdata['IndustryId']:'0';
      
      // get ratting image
      $ratingAvg = roundRatingValue($ratingAvg);
      $ratingImg = 'templates/new_version/images/rating/rating_0'.$ratingAvg.'.png';
      
      // check container is free or paid by default container
      if( $userDefaultTsProductId > 0){
         $containerPrice         = '0';
      }else{
         $containerPrice         =  (isset($projectdata['price']))?$projectdata['price']:'0';
      }
      
      // get used space of container
      $dirname               =   'media/'.LoginUserDetails('username').'/launchevents/'.$projectId.'/';
      $usedSpaceSizeInBytes  =   getFolderSize($dirname);
      $usedSpaceSize         =   bytestoMB($usedSpaceSizeInBytes,'mb');
      $usedSpaceSize         =   number_format($usedSpaceSize,2);
      
      //get extra space array  
      $extraSpaceArray       =  packageContainerPrice($usedSpaceSizeInBytes); 
      $isExtraSpace          =  $extraSpaceArray['isExtraSpace'];
      $ExtraSpaceSize        =  $extraSpaceArray['usedExtraSpace'];
      $ExtraSpaceTotalPrice  =  $extraSpaceArray['usedExtraSpacePrice'];
      
      //calculate container total price
      $containerTotalPrice    =  $containerPrice +  $ExtraSpaceTotalPrice; 
      
      //get launch session count
      $whereEvent           =  array('eventId' => '0','launchEventId' => $projectId);
      $sessionsData         =  $this->model_common->getDataFromTabel('EventSessions', 'sessionId',  $whereEvent, '', $orderBy='sessionId', $order='ASC');
      $sessionCount         =  (!empty($sessionsData))?count($sessionsData):'0';
      
	// get project image
	$projectImage = getPackageProjectImage($projectdata);
      
	// get toad currency sign
	$toadCurrencySign = $this->config->item('toadCurrencySgine');
	//calculate percent
	$vatPercent     =  $this->config->item('package_vat_percent');
	$vatPrice       = (($containerTotalPrice*$vatPercent)/100);
	// set total price of container including vat
	$containerTotalPrice = $containerTotalPrice+$vatPrice;
    ?>
	<div class="width100_per mt40  defaultP">
		<div>
			<span class="fl">
				<input type="checkbox" id="containerId_<?php echo $userContainerId; ?>" name="selectedContainerId[]" value="<?php echo $userContainerId; ?>" />
			</span>
			<span class="fl fs15">
				<b><?php echo $projectTitle; ?></b>
			</span>
		</div>
     
		<div class="sap_20 BB_dadada"></div>
		<div class="fl">
			<img alt="" width="100" class="border_cacaca mt2" src="<?php echo $projectImage;?>">
			<p class="pt5"><b>Launch</b></p>
		</div>
		<ul class="total fr">
			<li class="clearb" >
				<span class="display_cell p_head"> <span class="fs16 font_bold minwidth_165 ">Launch Showcase</span>
				<span class="fs13 pl10 pr36"> <?php echo $this->lang->line('validOneYear');?></span></span>
				<span class="price"><span id="totalProductPriceHtml"><?php echo (0< $containerPrice)?'€ '.number_format($containerPrice,'2'):"FREE";?></span> </span> 
			</li>
			<?php if($isExtraSpace){ ?>
				<li class="clearb   extra_space" >
					<span class="display_cell p_head ">
						<span class="fs16 font_bold minwidth_165"><?php echo $this->lang->line('extraSpace');?></span>
						<span class="fs13 font_notmal pl5 fr pr36">
							<span id="extraSpaceQty"><?php echo bytestoMB($ExtraSpaceSize,'mb');?></span>
							<span>MB</span>
						</span>
					</span>
					<span class="price "> 
						<?php echo $toadCurrencySign;?><span id="extraSpacePriceHtml"><?php echo number_format($ExtraSpaceTotalPrice,'2'); ?></span> 
					</span> 
				</li>
			<?php }
			
			if($vatPrice) { ?> 
				<li class="clearb  space_1" >
					<span class="p_head pr36 text_alignR "> 
						<?php 
						echo $this->lang->line('vat');
						echo $vatPercent;
						echo $this->lang->line('percente');
						?>
					</span>
					<span class="price"> 
						<span><?php echo $toadCurrencySign;?></span>
						<span id="vatPrice"><?php echo $vatPrice;?></span> 
					</span> 
				</li>
			<?php } 
			if($containerTotalPrice > 0) { ?>
			<li class="clearb BT_dadada" >
				<span class="red p_head font_bold pr36 mt10 mb10 text_alignR "> <?php echo $this->lang->line('total');?> </span>
				<span class="price red font_bold"> 
					<span id="cartTotalPriceHtml"><?php echo  (0< $containerTotalPrice)?'€ '.number_format($containerTotalPrice,'2'):"FREE";?></span> 
				</span> 
			</li>	
			<?php } ?>	
		</ul>
		<div class="fr position_absolute right-33 pt12">p.a.</div>
		<div class="sap_40 bb_F1592A"></div>
	</div>	

	<?php /* ?>
    <div class=" width100_per mt60 defaultP">
     <input type="checkbox" id="containerId_<?php echo $userContainerId; ?>" name="selectedContainerId[]" value="<?php echo $userContainerId; ?>" />
     <div class="collaborat_wrap pl15 pr15 pt8 pb15 fr width_545 shadow_light bdr_c3c3c3">
        <div class="bb_F1592A display_block width100_per fl  mb5 pb4">
           <h4 class="font_museoSlab fl mt6"><?php echo $projectTitle; ?></h4>
           <div class=" fr text_alignR fs13 font_weight lineH20 ">
              <p class="red">Launch</p>
              <p><?php echo $countryName; ?></p>
           </div>
        </div>
        <div class="collbartion_box fl width100_per  pt5 lineH14 fs11 ">
           <div class="fr color_666">
              <div class="eye_view icon_so"><?php echo $viewCount; ?></div>
              <div class="blog_view icon_so"><?php echo $craveCount; ?></div>
              <div class="rating_view icon_so"> <img  src="<?php echo base_url($ratingImg);?>" /></div>
              <div class="share_view icon_so pr0"><?php echo $reviewCount; ?></div>
           </div>
        </div>
        <ul  class=" fs13 collabration_wrap pt18 clearb fl width100_per">
           <li class="width_141"> <span class="pb9">Date<br />
             <?php echo dateFormatView($startDate,'d F Y'); ?>  </span> <span class="pb9">Type<br />
              <b class="red"><?php echo ($type == '1')?'Live':'Online'; ?> </b> </span> 
              
           </li>
           <li class="width152 bdrR_c3c3c3 bdrL_c3c3c3"><b class="fs14 fl pb10 clearb">Event Contents</b> 
           <span > <b class="red fs14"><?php echo $sessionCount; ?></b> Session</span>
            
            </li>
           <li class="pr0  pl0  bdr_non width180 pl0  mr-15"><img src="<?php echo $projectImage; ?>" alt="" class="maxWidth165px maxHeight113px" /></li>
        </ul>
     </div>
     <div class="display_table fr width_545 pr10 red fs16">
        <ul class="display_block collb_list pt25">
           <li><span class="fl">Event Showcase per annum</span> <span class="fr"> 
             <?php 
                echo (0< $containerPrice)?'€ '.number_format($containerPrice,'2'):"FREE";
              ?>
             </span></li>
            <?php if($isExtraSpace){ ?>
              <li><span class="fl"><?php echo bytestoMB($ExtraSpaceSize,'mb'); ?> MB Extra Storage Space</span> <span class="fr">€ <?php echo number_format($ExtraSpaceTotalPrice,'2'); ?></span></li>
              <li class=" BT_dadada pt8 mt5"> <span class="fr">  <?php echo (0< $containerPrice)?'€ '.number_format($containerTotalPrice,'2'):''; ?></span></li>
            <?php }else{ ?>
              <li class=" BT_dadada pt8 mt5"> <span class="fr">  &nbsp;</span></li>
            <?php } ?>
        </ul>
     </div>
    </div>
	<?php */ ?>
     
    <input type="hidden" name="<?php echo $userContainerId; ?>_containerPrice"  value="<?php echo  $containerPrice; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_extraSpacePrice" value="<?php echo  $ExtraSpaceTotalPrice; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_extraSpaceSize"  value="<?php echo  $ExtraSpaceSize; ?>">
    
    <input type="hidden" name="<?php echo $userContainerId; ?>_industrySection" value="Launch">
    <input type="hidden" name="<?php echo $userContainerId; ?>_industryType" value="<?php echo $containerType; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_projectId" value="<?php echo $projectId; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_title" value="<?php echo $projectTitle; ?>">
    <input type="hidden" name="<?php echo $userContainerId; ?>_price" value="<?php echo $containerPrice?>">
    <input type="hidden" name="containerId[]" value="<?php echo $userContainerId?>">


  <?php } } } ?>

</div>
