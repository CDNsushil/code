<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$counriesIntrestWorkingInput = array(
		'name'	=> 'intrestedCountryContainer',
		'id'	=> 'intrestedCountryContainer',
		'class'	=> 'textarea_small_bg clr_darkgrey required',
		'value'	=> zoneCountries($countriesInterestWorking),
		'cols'	=> 67,
		'rows'	=> 2,
		'readonly'	=> true
	);
	
	$intrestedCountriesID = array();
	if(!empty($countriesInterestWorking)){
		$intrestedCountriesID = explode('|',$countriesInterestWorking);
	}else{
		$intrestedCountriesID[]=0;
	}
?>

<div class="row">
	<?php
	if(isset($continentWiseCountry) && is_array($continentWiseCountry) && count($continentWiseCountry) > 0){ ?>
		<div class="position_relative mt20">
			<div class="cell shadow_wp strip_absolute left_225 shiping_field_divide">
				<!-- <img src="images/strip_blog.png"  border="0"/>-->
				  <table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%">
					<tbody>
					  <tr>
						<td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
					  </tr>
					  <tr>
						<td class="shadow_mid_small">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
					  </tr>
					</tbody>
				  </table>
				<div class="clear"></div>
			</div>
			 
			  <div class="row">
				<div class="cell">
				  <div class="Shiping_title mb20"> <span class="pr3">1. </span><?php echo $this->lang->line('selectContinent');?></div>
				  <div class="shiping_select_box01">
					<div class="mr10 ml10 mt10">
					  <?php
						$continentId=0;
						$continentCountries=array();
						$i=0;
						foreach($continentWiseCountry as $k=>$country){
							if($country->continentId !=$continentId && $country->continentId > 0){
								$continentId=$country->continentId; 
								$checked=$i==0?'checked':'';
								$i++;
								?>
								 <div class="defaultP">
									<input <?php echo $checked;?> type="radio" name="continentId"  value="<?php echo $continentId;?>" onclick="showCurrentHideEach('#countryListing<?php echo $continentId;?>','.countryListing')" />
								 </div>
								 <div class="cell ml10"><?php echo $country->continent;?></div>
								 <div class="clear seprator_8"> </div>
								<?php
							}
							$continentCountries[$country->continentId][$country->countryId]=$country->countryName;
						}?>
					</div>
				  </div>
				</div>
				<div class="cell ml115">
				  <div class="Shiping_title mb20"> <span class="pr3">2. </span> <?php echo $this->lang->line('selectCountries');?> </div>
					<?php
						$continentId=0;
						$i=0;
						foreach($continentCountries as $continentId=>$Countries){
							$dn=$i==0?'':'dn';?>
							 
							 <div class="countryListing <?php echo $dn?>" id="countryListing<?php echo $continentId;?>">
								<div class="shiping_select_box02 width220px height142px">	
								 <div class="mr10 ml15 mt10" >
									<?php
										$i=0;
										foreach($Countries as $countryId=>$countryName){
											$checked=in_array($countryId, $intrestedCountriesID)?'checked':''; 
											?>
											 <div class="defaultP">
												<input type="checkbox" continentId="<?php echo $continentId;?>" class="CheckBox CheckBox<?php echo $continentId;?>" name="countryCheckBox[]" id="country_<?php echo $continentId.'_'.$countryId;?>" value="<?php echo $countryId; ?>" title="<?php echo $countryName; ?>" <?php echo $checked;?> />
											 </div>
											 <div class="cell ml10 width135px"><?php echo $countryName;?></div>
											 <div class="bdr_below_checkbox clear"></div>
											 <?php
										}
									?>
									<div class="clear seprator_9"> </div>
								 </div>
								</div>
								
							</div>
							<?php
							$i++;
						}?>
				</div>
				<div class="clear"></div>
			  </div>
		</div>
		<div class="seprator_25 clear"></div>
		<div class="row">
			<div class=" width494px">
				<?php echo form_textarea($counriesIntrestWorkingInput); ?>
			</div>
			<div class="seprator_5 clear"></div>
			<div class="note_belw_textarea"> <?php echo $this->lang->line('competitionCountriesMsg');?></div>
		</div>
			
			<script>
				$(document).ready(function(){	
					$(".CheckBox").click(function(){
						
						continentId=$(this).attr('continentId');
						var countriesName = new Array();
						var countriesId = new Array();
						var names = '';
						var ids ='';
						
						var i=0;
						$('.CheckBox').each(function(index, value){
							if(this.checked && this.value > 0){
									countriesName[i]=this.title;
									countriesId[i]=this.value;
									i++;
							}
						});
						
						var countryCount = countriesName.length;
						if(countryCount>3) {
							$('#country_'+continentId+'_'+this.value).prop('checked', false);
							runTimeCheckBox();
							alert('Must be up to three countries');
							return false;
						}
						
						if(countriesId.length >= 1){
							names = countriesName.join(', ');
							ids=  '|'+countriesId.join('|');
						}
						
						$('#intrestedCountryContainer').val(names);
						$('#countriesInterestWorking').val(ids);
					});
				});
			</script>
			<?php
	 }
	 else{ ?>
		<div class="cell pro_title">
			<?php echo $this->lang->line('noRecord'); ?>
			<div class="clear"></div>
		 </div>
		<?php
	 }
	 ?>
</div>
<div class="seprator_25 clear row"></div>
