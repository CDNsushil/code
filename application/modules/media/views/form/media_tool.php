<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$lang=lang();
$mediaToolForm = array(
	'name'=>'mediaToolForm',
	'id'=>'mediaToolForm'
);

$baseUrl = formBaseUrl();

$subscriptionTypeInput = array(
	'name'	=> 'subscriptionType',
	'type'	=> 'hidden',
	'id'	=> 'subscriptionType',
	'value'	=>isset($subscriptionType)?$subscriptionType:0
);
$availableContainerInput = array(
	'name'	=> 'availableContainer',
	'type'	=> 'hidden',
	'id'	=> 'availableContainer',
	'value'	=>(isset($availableContainer) && !empty($availableContainer))?json_encode($availableContainer):0
);


$catHTML='';
$catSearch = false;
$catReplace = false;
if(isset($category) && !empty($category)){
	$catSearch = array();
	$catReplace = array();
	$i=0;
	foreach($category as $cat){
		$i++;
		$catSearch[] = "{{var cat$i}}";
		$catReplace[] = $cat->category;
		$checked= '';
		if(isset($projCategory) && ((int)$projCategory >=1) && ($cat->catId == $projCategory)){
			$checked= 'checked';
		}elseif($i == 1){
			$checked= 'checked';
		}
		if(count($category) >1){
			$catHTML.='<label class="pr47"><input type="radio" name="projCategory" value="'.$cat->catId.'" '.$checked.' >'.$cat->category.'</label>';
		}else{
			$catHTML.='<input type="hidden" name="projCategory" value="'.$cat->catId.'" '.$checked.' >';
		}
	}
}
$stepNumber = 1;
$salesActiveTab = '';
// set class for single tab
$singleTabCls = 'single_tab';
if((isset($category) && !empty($category) && count($category) > 1) && $subscriptionType != 1) {
	$singleTabCls = '';
}
?>

<div class="TabbedPanels tab_setting" id="TabbedPanels2"> 
    <ul class="TabbedPanelsTabGroup scond_li shipless <?php echo $singleTabCls;?>">
		<?php if(isset($category) && !empty($category) && count($category) > 1) { ?>
			<li class="TabbedPanelsTab TabbedPanelsTabSelected" id="setupStep1"><span>Step <?php echo $stepNumber; $stepNumber = $stepNumber +1; ?> <b>Type of Showcase*</b> </span></li>
		<?php } else {
			$salesActiveTab = 'TabbedPanelsTabSelected';
		} ?>
		<li class="TabbedPanelsTab <?php echo $salesActiveTab;?> " id="setupStep2"><span>Step <?php echo $stepNumber; $stepNumber = $stepNumber +1; ?> <b>Media Sales*</b></span></li>
        <?php if(isset($subscriptionType) && $subscriptionType == 1){ ?>
			<li class="TabbedPanelsTab " id="setupStep3"><span>Step <?php echo $stepNumber; $stepNumber = $stepNumber +1; ?> <b>Storage Space*</b></span> </li>
		<?php } ?>
    </ul>
	<div class="TabbedPanelsContentGroup width_665 m_auto Tabbed2"> 
		<?php 
		echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'saveMediaTools'.DIRECTORY_SEPARATOR),$mediaToolForm); 
			echo form_input($subscriptionTypeInput); 
			echo form_input($availableContainerInput); 
			 
		$showStep = '';
		$MediaCollectionHeading = 'A_MediaCollection';
		$StorageSpaceHeading = 'A_StorageSpace';
		$YourPricingHeading = 'B_YourPricing';
		$isStorageShow = 'dn';
		if(isset($subscriptionType) && $subscriptionType == 1) {
			$isStorageShow = '';
			/*
			?>
			<h3 class="red fs21  bb_aeaeae"><?php echo $this->lang->line('A_MediaShowcases');?></h3>
			<ul class="review ">
				<?php if(isset($availableContainer) && !empty($availableContainer)){
					
					$unusedFreeMediaShowcases  = $this->lang->line('unusedFreeMediaShowcases');
					if($catSearch && $catReplace){
						$unusedFreeMediaShowcases  =str_replace($catSearch,$catReplace,$unusedFreeMediaShowcases);
					}
					echo '<li>'.$unusedFreeMediaShowcases.'</li>';
				}else{
					$usedFreeMediaShowcases  = str_replace('{{var price}}',$this->config->item('defaultMediaContainerPrice'),$this->lang->line('usedFreeMediaShowcases'));
					if($catSearch && $catReplace){
						$usedFreeMediaShowcases = str_replace($catSearch,$catReplace,$usedFreeMediaShowcases);
					}
					echo '<li>'.$usedFreeMediaShowcases.'</li>';
				}
				echo '<li>'.str_replace('{{var membershipInfoURL}}',base_url(lang().'/package/information'),$this->lang->line('upgradeYourMembership')).'</li>';
				?>
			</ul>
			<?php if(isset($availableContainer) && !empty($availableContainer)){
				$countContainer=count($availableContainer);
				echo '<div class="sap_35"></div>
					  <div class="butn fl"> <a class="fs16 letter_Spoint2 pr12 b_f7f7f7 bdr_b4b4b4" href="javascript:void(0);">'.str_replace('{{var countContainerHTML}}','<b class="fs21 pl4 pr4"> '.$countContainer.' </b>',$this->lang->line('freeMediaToolsavailable')).'</a></div>';
			}?>
			
			<?php
			*/
			$MediaCollectionHeading = 'B_MediaCollection';
			$StorageSpaceHeading = 'B_StorageSpace';
			$YourPricingHeading = 'C_YourPricing';
		 }
		 /*--------- Step Type of Showcase start here ---------*/
		 if(isset($category) && !empty($category) && count($category) > 1){
			$showStep = '';
			echo '<div class="c_1 clearb '.$showStep.'" id="step1ContentArea">';
				if(isset($subscriptionType) && $subscriptionType == 1){
					$StorageSpaceHeading = 'C_StorageSpace';
					$YourPricingHeading = 'D_YourPricing';
				}
				$MediaCollectionHeading  = $this->lang->line($MediaCollectionHeading);
				if($catSearch && $catReplace){
					$MediaCollectionHeading  =str_replace($catSearch,$catReplace,$MediaCollectionHeading);
				}
				?>
			
				<div class="c_1 clearb option_album">
				  <h3 class="red fs21 width635 bb_aeaeae  whitespace_now"><?php echo $MediaCollectionHeading;?></h3>
				  <div class="defaultP mt35 display_inline_block" >
					<?php echo $catHTML;?>
				  </div>
				</div> 
				<div class="sap_25"></div>
				<ul class="org_list">
					<li class="icon_1 red">This selection cannot be changed.</li>
				</ul>
				
				<?php
				$StorageSpaceHeading = 'B_StorageSpace';
				$YourPricingHeading = 'C_YourPricing';
				$showStep = 'dn';
				?>
				<div class=" fs14 fr btn_wrap display_block mt15 mb10 font_weight"  >
					<input type="button" value="<?php echo $this->lang->line('cancel');?>" class=" bg_ededed bdr_b1b1b1  mr10" onclick="manageNextStep(0)">
					<button type="button" class="b_F1592A bdr_F1592A " onclick="manageNextStep(1)"><?php echo $this->lang->line('next');?> </button>
				</div>
			</div>
		<?php 
		}
		/*--------- Step Type of Showcase end here ---------*/
		?>
		
		<!----------- Step Media Sales start here -------->
		<div class="c_1 clearb <?php echo $showStep;?>"  id="step2ContentArea">
			<h3 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('mediaSales');?></h3>
				<ul class="review fl mt7	">
					<li><?php echo $this->lang->line('wantToSsellmediaCollection');?></li>
				</ul>
				<div class=" mt28 mb20 ml30 butn pad_2 b_f7f7f7 fs16 bdr_b4b4b4 lineH18 fl"> 
					<span class="defaultP table_cell fs14">
						<?php		
						if(isset($projSellstatus) && ($projSellstatus =='t')){
							$projSellstatusYes= 'checked';
							$projSellstatusNo= '';
						}else{
							$projSellstatusYes= '';
							$projSellstatusNo= 'checked';
						} ?>
							
						<label>
							<input type="radio" value="f" name="projSellstatus" id="projSellstatus" class="price_no projSell" checked <?php //echo $projSellstatusNo;?>>
							<?php echo $this->lang->line('No');?></label>
						<label>
							<input type="radio" value="t" name="projSellstatus" id="projSellstatus" class="price_yes projSell" <?php //echo $projSellstatusYes;?>>
							<?php echo $this->lang->line('Yes');?> 
						</label>
					</span> 
				</div>
				<div id="donationDiv">
					<ul class="review fl">
						<li><?php echo $this->lang->line('askForDonation');?></li>
					</ul>
					<div class="width404 fl">
						<div class=" mt28 mb30  mr0 butn pad_2 b_f7f7f7 fs16 bdr_b4b4b4 lineH18 fr"> 
							<span class="defaultP table_cell fs14">
								<?php		
								if(isset($projDonations) && ($projDonations =='t')){
									$projDonationsYes= 'checked';
									$projDonationsNo= '';
								} else {
									$projDonationsYes= '';
									$projDonationsNo= 'checked';
								} ?>
									
								<label>
									<input type="radio" value="f" name="projDonations" id="projDonationsNo" class="price_no" checked <?php //echo $projDonationsNo;?>>
									<?php echo $this->lang->line('No');?></label>
								<label>
									<input type="radio" value="t" name="projDonations" id="projDonationsYes" class="price_yes" <?php //echo $projDonationsYes;?>>
									<?php echo $this->lang->line('Yes');?> 
								</label>
							</span> 
						</div>
					</div>
				</div>
				<ul class="org_list">
					<li class="icon_1 red">You need a Paypal to sell on Toadsquare.<br/>This selection can not be changed.</li>
					<li class="icon_2">You can sell files for download or pieces of work that you ship to buyer .<br/>
					You keep all copyright to your work.
					</li>
				</ul>
				
				<div class=" fs14 fr btn_wrap display_block mt15 mb10 font_weight"  >
					<input type="button" value="<?php echo $this->lang->line('cancel');?>" class=" bg_ededed bdr_b1b1b1  mr10" onclick="manageNextStep(0)">
					<?php if(isset($subscriptionType) && $subscriptionType == 1) { ?>
						<button type="button" class="b_F1592A bdr_F1592A " onclick="manageNextStep(2)"><?php echo $this->lang->line('next');?> </button>
					<?php } else { ?>
						<button type="submit" class="b_F1592A bdr_F1592A "><?php echo $this->lang->line('next');?> </button>
					<?php } ?>
				</div>
			</div>
			<!----------- Step Media Sales end here -------->
			
			<!----------- Step Storage Space start here -------->
			<div class="c_1 clearb dn <?php //echo $isStorageShow;?>"  id="step3ContentArea">
				<h3 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('buyExtraSpace');?></h3>
				<ul class="review mb4">
					<li>Each Media Showcase comes with 100 MB of storage space.</li>
					<li>If know your media files are larger , you can buy extra storage space now.</li>					
				</ul>
				<div class="sap_25"></div>
				<div class="pl22">
					Or you can add it later. Space costs 0.80 per 100 MB. Or you can upgrade your membership and
					get a lot more space. <a href="<?php echo base_url(lang().'/package/information');?>"> See membership information.</a>
				</div>
				<div class="sap_40"></div>
				<div class=" butn b_f7f7f7 fs17 ml22imp	 fl bdr_b4b4b4 lineh16"> 
				<div class=" table_cell pad_2"> 
					<span class="fl lineH23 pr15">Add extra space</span>
					<span class="defaultP pr0 fs14">
						<label>
							<input type="radio" value="f" name="addSpace" id="addSpaceNo" class="price_no" checked>
							<?php echo $this->lang->line('No');?></label>
						<label>
							<input type="radio" value="t" name="addSpace" id="addSpaceYes" class="price_yes" >
							<?php echo $this->lang->line('Yes');?> 
						</label>
					</span> 
				</div></div>
				<div class=" fs14 fr btn_wrap display_block mb10 font_weight"  >
					<input type="button" value="<?php echo $this->lang->line('cancel');?>" class=" bg_ededed bdr_b1b1b1  mr10" onclick="manageNextStep(0)">
					<button type="submit" class="b_F1592A bdr_F1592A " id="nextbuttonMediaTool" ><?php echo $this->lang->line('next');?> </button>
				</div>
			</div>
		<?php 
		echo '<div class="display_none">'.$catHTML.'</div>';
		echo form_close(); ?>
	</div>
</div>	


<?php /* ?>
<!--========================== stage 1 :- second tab  ==============================-->
<div class="TabbedPanelsContentGroup width_665 m_auto "> 
	<div class="TabbedPanelsContent Tabbed2 width635 m_auto clearb TabbedPanelsContentVisible" style="display: block;">
		<?php 
		echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'saveMediaTools'.DIRECTORY_SEPARATOR),$mediaToolForm); 
			echo form_input($subscriptionTypeInput); 
			echo form_input($availableContainerInput); 
			?>
			<div class="c_1 clearb">
				<?php 
				$MediaCollectionHeading = 'A_MediaCollection';
				$StorageSpaceHeading = 'A_StorageSpace';
				$YourPricingHeading = 'B_YourPricing';
				if(isset($subscriptionType) && $subscriptionType == 1){
					?>
					<h3 class="red fs21  bb_aeaeae"><?php echo $this->lang->line('A_MediaShowcases');?></h3>
					<ul class="review ">
						<?php if(isset($availableContainer) && !empty($availableContainer)){
							
							$unusedFreeMediaShowcases  = $this->lang->line('unusedFreeMediaShowcases');
							if($catSearch && $catReplace){
								$unusedFreeMediaShowcases  =str_replace($catSearch,$catReplace,$unusedFreeMediaShowcases);
							}
							echo '<li>'.$unusedFreeMediaShowcases.'</li>';
						}else{
							$usedFreeMediaShowcases  = str_replace('{{var price}}',$this->config->item('defaultMediaContainerPrice'),$this->lang->line('usedFreeMediaShowcases'));
							if($catSearch && $catReplace){
								$usedFreeMediaShowcases = str_replace($catSearch,$catReplace,$usedFreeMediaShowcases);
							}
							echo '<li>'.$usedFreeMediaShowcases.'</li>';
						}
						echo '<li>'.str_replace('{{var membershipInfoURL}}',base_url(lang().'/package/information'),$this->lang->line('upgradeYourMembership')).'</li>';
						?>
					</ul>
					<?php if(isset($availableContainer) && !empty($availableContainer)){
						$countContainer=count($availableContainer);
						echo '<div class="sap_35"></div>
							  <div class="butn fl"> <a class="fs16 letter_Spoint2 pr12 b_f7f7f7 bdr_b4b4b4" href="javascript:void(0);">'.str_replace('{{var countContainerHTML}}','<b class="fs21 pl4 pr4"> '.$countContainer.' </b>',$this->lang->line('freeMediaToolsavailable')).'</a></div>';
					}?>
					
					<?php
					$MediaCollectionHeading = 'B_MediaCollection';
					$StorageSpaceHeading = 'B_StorageSpace';
					$YourPricingHeading = 'C_YourPricing';
				 }
				 
				 if(isset($category) && !empty($category)){
					if(count($category) > 1){
						if(isset($subscriptionType) && $subscriptionType == 1){
							$StorageSpaceHeading = 'C_StorageSpace';
							$YourPricingHeading = 'D_YourPricing';
						}
						$MediaCollectionHeading  = $this->lang->line($MediaCollectionHeading);
						if($catSearch && $catReplace){
							$MediaCollectionHeading  =str_replace($catSearch,$catReplace,$MediaCollectionHeading);
						}
						?>
					
						<div class="c_1 clearb option_album">
						  <h3 class="red fs21 width635 bb_aeaeae  whitespace_now"><?php echo $MediaCollectionHeading;?></h3>
						  <div class="defaultP mt20 display_inline_block" >
							<?php echo $catHTML;?>
						  </div>
						</div> 
					
						<?php
						$StorageSpaceHeading = 'B_StorageSpace';
						$YourPricingHeading = 'C_YourPricing';
					}else{
						echo $catHTML;
					}
				}?>
				<div class="c_1 clearb">
					<h3 class="red fs21  bb_aeaeae"><?php echo $this->lang->line($StorageSpaceHeading);?></h3>
					<ul class="review mb4">
						<?php
						if(isset($subscriptionType) && $subscriptionType == 1){
							echo '<li>'.str_replace('{{var defaultContainerStorageSpace}}',$this->config->item('defaultContainerStorageSpace'),$this->lang->line('mediaShowcaseStorageSpace')).'</li>'; 
							$addStorageSpace_freeMember  = $this->lang->line('addStorageSpace_freeMember');
							$search = array("{{var defaultPrice_per_unitofStorageSpace_freeMember}}", "{{var defaultUnitofStorageSpace_freeMember}}", "{{var defaultStorageSpace_paidMember}}", "{{var membershipInfoURL}}");
							$replace   = array($this->config->item('defaultPrice_per_unitofStorageSpace_freeMember'), $this->config->item('defaultUnitofStorageSpace_freeMember'),$this->config->item('defaultStorageSpace_paidMember'),base_url(lang().'/package/information'));
							echo '<li>'.str_replace($search,$replace,$addStorageSpace_freeMember).'</li>';
							echo '<li>'.$this->lang->line('addStorageSpaceLater').'</li>';
						}else{
							$memershipRemainingSpace  = $this->lang->line('memershipRemainingSpace');
							$search = array("{{var remainingStorageSpace}}", "{{var defaultStorageSpace_paidMember}}", "{{var defaultPrice_per_unitofStorageSpace_paidMember}}", "{{var defaultUnitofStorageSpace_paidMember}}");
							$replace   = array($remainingSize, $this->config->item('defaultStorageSpace_paidMember'),$this->config->item('defaultPrice_per_unitofStorageSpace_paidMember'),$this->config->item('defaultUnitofStorageSpace_paidMember'));
							echo '<li>'.str_replace($search,$replace,$memershipRemainingSpace).'</li>';
							echo '<li>'.$this->lang->line('orDeleteContentToFreeUpSpace').'</li>';
						}?>
					</ul>
					<div class="sap_35"></div>
					<div class="butn b_f7f7f7 fs17 fl bdr_b4b4b4 lineh16">
						<div class="table_cell pad_2"> <span class="fl lineH23 pr15"><?php echo $this->lang->line('addExtraSpace');?></span> <span class="defaultP fs14 pr0">
							<?php
							
								if(isset($addSpace) && ((int)$addSpace ==1)){
									$addSpaceYes= 'checked';
									$addSpaceNo= '';
								}else{
									$addSpaceYes= '';
									$addSpaceNo= 'checked';
								}
							
							?>
							<label>
								<input  type="radio" name="addSpace" value="0" <?php echo $addSpaceNo;?> class="no_media" />
								<?php echo $this->lang->line('No');?> </label>
							<label>
								<input  type="radio" name="addSpace" value="1"  class="add_media" <?php echo $addSpaceYes;?> />
								<?php echo $this->lang->line('Yes');?> </label>
							</span> </div>
					</div>
				</div>
				<div class="c_1 clearb">
					<h3 class="red fs21 bb_aeaeae"><?php echo $this->lang->line($YourPricingHeading);?></h3>
					<ul class="review fl">
						<li><?php echo $this->lang->line('wantToSsellmediaCollection');?></li>
					</ul>
					<div class=" mt28 mb20 ml23 butn pad_2 b_f7f7f7 fs16 bdr_b4b4b4 lineH18 fl"> <span class="defaultP table_cell fs14">
						<?php
							
								if(isset($projSellstatus) && ($projSellstatus =='f')){
									$projSellstatusYes= '';
									$projSellstatusNo= 'checked';
								}else{
									$projSellstatusYes= 'checked';
									$projSellstatusNo= '';
								}
							
							?>
						
						<label>
							<input type="radio" value="f" name="projSellstatus" id="projSellstatus" class="price_no" <?php echo $projSellstatusNo;?>>
							<?php echo $this->lang->line('No');?></label>
						<label>
							<input type="radio" value="t" name="projSellstatus" id="projSellstatus" class="price_yes" <?php echo $projSellstatusYes;?>>
							<?php echo $this->lang->line('Yes');?> </label>
						</span> </div>
				</div>
			</div>
			<div class="c_1 clearb  display_inline_block">
				<ul class="org_list">
					<li class="icon_1 red"><?php echo $this->lang->line('notification_salesWillUpdated');?></li>
				</ul>
				<div class=" fs14 fr btn_wrap display_block mt15 mb10 font_weight"  >
					<button class=" bg_ededed bdr_b1b1b1  mr5"><?php echo $this->lang->line('cancel');?> </button>
					<button type="submit" class="b_F1592A bdr_F1592A "><?php echo $this->lang->line('next');?> </button>
				</div>
			</div>
			<?php 
		echo form_close(); ?>
	</div>
</div>
<?php */ ?>
<script>
	function manageNextStep(stepNumber) {
		if(stepNumber==1) {
			$('#step1ContentArea').hide();
			$('#step2ContentArea').show();
			$('#setupStep2').addClass('TabbedPanelsTabSelected');
			$('#setupStep1').removeClass('TabbedPanelsTabSelected');
		} else if(stepNumber==2) {
			$('#step2ContentArea').hide();
			$('#step3ContentArea').show();
			$('#setupStep3').addClass('TabbedPanelsTabSelected');
			$('#setupStep2').removeClass('TabbedPanelsTabSelected');
		} else {
			window.location.href = baseUrl+'/home';
		}
	}
	
	 /**
	* Manage next step of state tax listing
	*/
	$('.projSell').click(function() {
        
        var projDonations = $('input[name=projSellstatus]:checked').val();
        if(projDonations == 't') {
			$('#donationDiv').fadeOut();
        } else {
			 $('#donationDiv').fadeIn();
        }
	});
	
  	$('.projSell').click(function() {
        
        var projDonations = $('input[name=projSellstatus]:checked').val();
        if(projDonations == 't') {
			$('#donationDiv').fadeOut();
        } else {
			 $('#donationDiv').fadeIn();
        }
	});


    // To check paypal Detail before submit
    // Amit Neema - 10-04-2015
    $("#projDonationsYes").click(function() {
        $.post('<?php echo $baseUrl.'/checkpaypalDetail';?>','', function(data) {
        if(data){
                if(data.result == '0') {
                   customAlert('Please fill your seller paypal detail first');
                    $('#projDonationsYes').attr("checked",false);
                    $('#projDonationsYes').parent('div').removeClass('ez-selected');
                    $('#projDonationsNo').attr("checked","checked");
                    $('#projDonationsNo').parent('div').addClass('ez-selected');
                   }
            }
        }, "json");
    });
    
  
</script>
		
