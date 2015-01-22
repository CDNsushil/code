<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$competitionCounriesInput = array(
		'name'	=> 'competitionCounries',
		'id'	=> 'competitionCounries',
		'class'	=> 'textarea_small_bg clr_darkgrey required',
		'value'	=> zoneCountries($competitionData->competitionCountries),
		'cols'	=> 67,
		'rows'	=> 2,
		'readonly'	=> true
	);
	
	$competitionCountriesID = array();
	if(!empty($competitionData->competitionCountries)){
		$competitionCountriesID = explode('|',$competitionData->competitionCountries);
	}else{
		$competitionCountriesID[]=0;
	}
	
?>

<div class="row">
	<?php
	if(isset($continentWiseCountry) && is_array($continentWiseCountry) && count($continentWiseCountry) > 0){ ?>
		<div class="position_relative ml30 mt20">
			<div class="cell shadow_wp strip_absolute left_232 shiping_field_divide">
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
				<div class="cell ml120">
				  <div class="Shiping_title mb20"> <span class="pr3">2. </span> <?php echo $this->lang->line('selectCountries');?> </div>
					<?php
						$continentId=0;
						$i=0;
						foreach($continentCountries as $continentId=>$Countries){
							$dn=$i==0?'':'dn';?>
							 
							 <div class="countryListing <?php echo $dn?>" id="countryListing<?php echo $continentId;?>">
								<div class="bdr_c4c4c4 bg_white bdr_Radius_2 mb10">
										<div class="defaultP ml15 pt5 pb1">
											<input type="checkbox" class="CheckBox" onclick="checkUncheck(this, 0, '.CheckBox<?php echo $continentId;?>');" name="checkAll<?php echo $continentId;?>" id="checkAll<?php echo $continentId;?>" value="0" >
										</div>
										<label class="ml10 mt4 fl cell font_opensansSBold">All</label>
										<div class="clear"></div>
								</div>
								<div class="shiping_select_box02 width220px height142px">	
								 <div class="mr10 ml15 mt10" >
									<?php
										$i=0;
										foreach($Countries as $countryId=>$countryName){
											$checked=in_array($countryId, $competitionCountriesID)?'checked':''; 
											?>
											 <div class="defaultP">
												<input type="checkbox" continentId="<?php echo $continentId;?>" class="CheckBox CheckBox<?php echo $continentId;?>" name="countryCheckBox[]" value="<?php echo $countryId; ?>" title="<?php echo $countryName; ?>" <?php echo $checked;?> />
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
		<div class="row ml30">
			<div class=" width494px">
				<?php echo form_textarea($competitionCounriesInput); ?>
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
						
						if(countriesId.length >= 1){
							names = countriesName.join(', ');
							ids=  '|'+countriesId.join('|');
						}
						
						$('#competitionCounries').val(names);
						$('#competitionCountriesId').val(ids);
							
						checkUncheckParent('.CheckBox'+continentId,'#checkAll'+continentId);
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
