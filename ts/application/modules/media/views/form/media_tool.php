<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
$lang=lang();
$mediaToolForm = array(
	'name'=>'mediaToolForm',
	'id'=>'mediaToolForm'
);
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
?>
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

		
