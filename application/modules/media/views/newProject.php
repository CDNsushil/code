<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$formAttributes = array(
	'name'=>'customForm',
	'id'=>'customForm'
);
$projName = array(
	'name'	=> 'projName',
	'id'	=> 'projName',
	'class'	=> 'required width556px',
	'value'	=> set_value('projName')?set_value('projName'):@string_decode($LID->projName),
	/*'placeholder'	=> $label['projNameTitle'],*/
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$projGenreFree = array(
	'name'	=> 'projGenreFree',
	'id'	=> 'projGenreFree',
	'class'	=> 'width246px',
	'value'	=> set_value('projGenreFree')?set_value('projGenreFree'):@$LID->projGenreFree,
	/*'placeholder'	=> $label['projNameTitle'],*/
	'minlength'	=> 2,
	'maxlength'	=> 45,
	'size'	=> 50
);
if(isset($LID->projReleaseDate) && $LID->projReleaseDate!=''){
	$releasedDate = set_value('projReleaseDate')?set_value('projReleaseDate'):@substr(@$LID->projReleaseDate, 0,-8);
	$releasedDate = date('F Y',strtotime($releasedDate));
}else $releasedDate = '';

$projReleaseDate = array(
	'name'	=> 'projReleaseDate',
	'id'	=> 'projReleaseDate',
	'value'	=> $releasedDate,
	/*'placeholder'	=> $label['FvReleaseDateTitle'],*/
	'maxlength'	=> 80,
	'size'	=> 30,
	/*'class'       => 'width246px date-input',*/
	'class'       => 'width246px',
	'readonly' =>true
);

$projDonations = array(
	'name'	=> 'projDonations',
	'id'	=> 'projDonations',
	'type'	=> 'checkbox',
	'value'	=> 't'
);
$donation=set_value('projDonations')?(set_value('projDonations')=='t'?true:false):@$LID->projDonations=='t'?true:false;
if($donation){
	$projDonations['checked']=true;
}
		
$classification = array(
	'name'	=> 'classification',
	'id'	=> 'classification',
	'class'	=> 'width246px formTip',
	'value'	=> set_value('classification')?set_value('classification'):@$LID->classification,
	'minlength'	=> 2,
	'title' => $label['classificationTitle'],
	'maxlength'	=> 50,
	'size'	=> 50
);
$classifiedBy = array(
	'name'	=> 'classifiedBy',
	'id'	=> 'classifiedBy',
	'class'	=> 'width246px',
	'value'	=> set_value('classifiedBy')?set_value('classifiedBy'):@$LID->classifiedBy,
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$projSubtitle1 = array(
	'name'	=> 'projSubtitle1',
	'id'	=> 'projSubtitle1',
	'class'	=> 'width246px',
	'value'	=> set_value('projSubtitle1')?set_value('projSubtitle1'):@$LID->projSubtitle1,
	/*'placeholder'	=> $label['fvSubtitle1Title'],*/
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$projSubtitle2 = array(
	'name'	=> 'projSubtitle2',
	'id'	=> 'projSubtitle2',
	'class'	=> 'width246px',
	'value'	=> set_value('projSubtitle2')?set_value('projSubtitle2'):@$LID->projSubtitle2,
	/*'placeholder'	=> $label['fvSubtitle2Title'],*/
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);
$projDubbing1 = array(
	'name'	=> 'projDubbing1',
	'id'	=> 'projDubbing1',
	'class'	=> 'width246px',
	'value'	=> set_value('projDubbing1')?set_value('projDubbing1'):@$LID->projDubbing1,
	/*'placeholder'	=> $label['fvDubbing1Title'],*/
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);
$projDubbing2 = array(
	'name'	=> 'projDubbing2',
	'id'	=> 'projDubbing2',
	'class'	=> 'width246px',
	'value'	=> set_value('projDubbing2')?set_value('projDubbing2'):@$LID->projDubbing2,
	/*'placeholder'	=> $label['fvDubbing2Title'],*/
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);
$projectid = array(
	'name'	=> 'projectid',
	'type'	=> 'hidden',
	'id'	=> 'projectid',
	'value'	=> @$LID->projectid?@$LID->projectid:0
);



?>

<script type="text/javascript">
  $(function () {
	  $('#projReleaseDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
  });
</script>

<div class="row form_wrapper">
	
	<div class="row">
		<div class="cell frm_heading">
			<h1>
			<?php 
				if($indusrty=='photographyNart') 
					$descriptionLabel = $label['PADescriptionLabel'];
				else 
					$descriptionLabel = $label['projectDescriptionLabel'];
				
				echo $descriptionLabel;
			?>
			</h1>
		</div>
		<?php echo $header; ?>
	</div>
	
	<div class="row position_relative">	
		<?php $this->load->view("common/strip");?>
		<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
			<input type="hidden" name="sectionId" value="<?php echo $sectionId;?>">
			 <div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $label['title'];?></label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($projName); ?>
					<div class="row wordcounter"><?php echo form_error($projName['name']); ?></div>
				</div>
			 </div>
			 
			<?php 
				$value=set_value('projShortDesc')?set_value('projShortDesc'):@$LID->projShortDesc;
				$value=htmlentities($value);
				$data=array('name'=>'projShortDesc','id'=>'projShortDesc','value'=>$value, 'required'=>'required', 'labelText'=>'loglineDescription');
				$this->load->view("common/oneline_description",$data);
			?>

			<?php 
				$value=set_value('projTag')?set_value('projTag'):@$LID->projTag;
				$value=htmlentities($value);
				$data=array('name'=>'projTag','id'=>'projTag','value'=>$value,'required'=>'required', 'labelText'=>'tagWords');
				$this->load->view("common/tag_words",$data);
			?>
			<div class="seprator_25 clear row"></div>
			<?php
				if($indusrty=='educationMaterial'){
					$projType='';
					?>
					<div class="row" id="indusrtyIdDiv">
						 <div class="cell label_wrapper"><label class="select_field"><?php echo $label['industry'];?></label></div>
						 <div class="cell frm_element_wrapper">
								<div class="fl" id="indusrtyIdList">
									<?php 
										$IndustryId=@$LID->projectindustryid;
										if( ! $IndustryId > 0){
											$IndustryId = '';
										}
										$industryList = getIndustryList();
										echo form_dropdown('IndustryId', $industryList, $IndustryId,'id="IndustryId" class="required" ');
										echo '<input type="hidden" id="projCategory" name="projCategory" value="'.$LID->projCategory.'" />';
									?>
								</div>
						</div>
					</div>
					<?php
				}
				/*elseif($indusrty=='news' || $indusrty=='reviews'){
					$projType='';
					?>
					<div class="row" id="indusrtyIdDiv">
						 <div class="cell label_wrapper"><label class="select_field"><?php echo $label['sections'];?></label></div>
						 <div class="cell frm_element_wrapper">
								<div class="fl" id="indusrtyIdList">
									<?php 
										$IndustryId=@$LID->projectindustryid;
										if( ! $IndustryId > 0){
											$IndustryId = '';
										}
										$industryList = getIndustryList($lang=lang(),$isSection=1);
										echo form_dropdown('IndustryId', $industryList, $IndustryId,'id="IndustryId" class="required" ');
										echo '<input type="hidden" id="projCategory" name="projCategory" value="'.$LID->projCategory.'" />';
									?>
								</div>
						</div>
					</div>
					<?
				}*/
			?>
			<?php
			$projCategoryList=getProjCategoryList('', $lang, 'selectCategory',$entityId);
			next($projCategoryList); 
			$projCategory=key($projCategoryList);
			$projCategory=(isset($LID->projCategory) && $LID->projCategory > 0)?$LID->projCategory:$projCategory;
			$projectTypeList = getTypeList('', $lang,'selectProjectType',$projCategory);
			next($projectTypeList); 
			$projType=key($projectTypeList);
			
			if( !($indusrty=='news' || $indusrty=='reviews' || $indusrty=='educationMaterial') ) { ?>	
				<div class="row">
					<div class="label_wrapper cell">
						<label class="select_field"><?php echo $label['projectStyle'];?></label>
					</div><!--label_wrapper-->
					
					<div class=" cell frm_element_wrapper">
						<div class="row mt5">
						<?php 
							$projCategory=set_value('projCategory')?set_value('projCategory'):@$LID->projCategory?@$LID->projCategory:$projCategory;
							if(@$LID->projCategory > 0){
								echo "<div class='orange fmoss pt2' id='projCategoryDiv'>".$LID->category."</div>";
								echo '<input type="hidden" id="projCategory" name="projCategory" value="'.$LID->projCategory.'" />';
							}
							else{
								
								$defaultOption=$this->lang->line('selectGenre');
								echo projCategoryInRadio($indusrtyId, $lang, $defaultOption,$entityId,$projCategory);
								
								if($indusrty=='filmNvideo' || $indusrty=='writingNpublishing')
								echo '<div class="row f11 pt5">'.$this->lang->line('chooseCarefully').'</div>';
								
								//echo form_dropdown('projCategory', $projCategoryList, $projCategory ,'id="projCategory" class="single required" onchange="getTypeList(\'projectTypeList\',\'projGenre\','.$indusrtyId.',this.value,\''.$defaultOption.'\');" ');
							}
							?>
						</div>	
					</div>
				</div>

				<div class="row">
					<div class="cell label_wrapper"><label class="select_field"><?php echo $label['projectType'];?></label></div>
					<div class="cell frm_element_wrapper">
						<div class="fl" id="projectTypeList" >
							<?php 
								$projType=set_value('projType')?set_value('projType'):@$LID->projType?@$LID->projType:0;
								if( ! $projType > 0){
									$projType = '';
								}
								echo form_dropdown('projType', $projectTypeList, $projType,'id="projType" class="required single" onchange="getGenerList(\'subGenreList\',this.value);"');
							?>
						</div>
						<div class="row wordcounter"><?php echo form_error('projType'); ?></div>
					</div>
				</div>

				
				<?php
			}else{
				echo '<input type="hidden" id="projCategory" name="projCategory" value="'.$projCategory.'" />';
				echo '<input type="hidden" id="projType" name="projType" value="'.$projType.'" />';
			}?>
			<?php
			if( !($indusrty=='news' || $indusrty=='reviews') ) { 
				
                      if($indusrty=='educationMaterial') {
						  
						    $genreLabel = $label['genreType'];
						    $SubGenreLabel = $label['genreFreeSub'];								 
						 } else {							 
							  $genreLabel = $label['genre'];
						      $SubGenreLabel = $label['subGenre'];
						     } 
				
				
				
				?>		
				<div class="row" id="projGenreDiv">
					 <div class="cell label_wrapper"><label class="select_field"><?php echo $genreLabel;?></label></div>
					 <div class="cell frm_element_wrapper">
							<div class="fl" id="subGenreList">
								<?php 
										$projGenre=set_value('projGenre')?set_value('projGenre'):@$LID->projGenre;
										if( ! $projGenre > 0){
											$projGenre = '';
										}
										
										$subgenre = getGenerList($projType,'', $lang,'selectGenre',$entityId);
										echo form_dropdown('projGenre', $subgenre, $projGenre,'id="projGenre" class="required" ');
								?>
							</div>
							<div class="row wordcounter"><?php echo form_error('projGenre'); ?></div>
					</div>
				</div>
				 <div class="row">
					<div class="cell label_wrapper"><label><?php echo $SubGenreLabel;?></label></div>
					<div class="cell frm_element_wrapper" >
						<?php echo form_input($projGenreFree); ?>
						<div class="row wordcounter"><?php echo form_error($projGenreFree['name']); ?></div>
					</div>
				 </div>
			<?php
			} 
			
			/*if(!($indusrty=='news' || $indusrty=='reviews')){?>
			<div class="seprator_25 clear row"></div>
			<div class="row">
			<div class="cell label_wrapper"> <label class="select_field"><?php echo $label['salesInformation'];?></label></div>
			<div class="cell frm_element_wrapper">
					 <div class="row pt5">
					 <?php
						$projSellstatus=set_value('projSellstatus')?set_value('projSellstatus'):@$LID->projSellstatus;
						$checked='checked';
						$dn='';
						if($projSellstatus == 't'){
							$dn = 'dn';
							$checked = '';
						}
					?>
					<div class="cell defaultP" onClick="$('#DonationRow').hide();">
					  <input type="radio" id="projSellstatus" name="projSellstatus" <?php if($projSellstatus=='t') echo 'checked';?> value="t" />
					</div>
					
					<div class="cell mr8">
					  <label class="lH25"><?php echo $label['sell'];?></label>
					</div>
					
					<div class="cell defaultP " onclick="$('#DonationRow').show();">
						<input type="radio" id="projSellstatusf" name="projSellstatus" <?php echo $checked;?> value="f" />
					</div>
					
					<div class="cell">
					  <label class="lH25"><?php echo $label['free'];?></label>
					</div>
				  </div>
			 <div class="row f11 pt5"><?php echo $this->lang->line('yourSellerSetting1').'<a href="'.base_url('dashboard/globalsettings').'" class="ptr dash_link_hover">'.$this->lang->line('yourSellerSetting2').'</a>'.$this->lang->line('yourSellerSetting3');?></div>
			 </div>
			</div>
			 
			<?php
			$displayDonation=$dn;
		}else{
			
			$displayDonation='';
		}?>
		
		<div class="row <?php echo $displayDonation;?>" id="DonationRow" >
			<div class="cell label_wrapper"><label><?php echo $label['donation'];?></label></div>
			<!-- Day -->
			<div class="cell frm_element_wrapper mt5">
				<div class="cell defaultP">
					<?php echo form_input($projDonations); ?>
				</div>
				<div class="cell">
				  <?php echo $label['doYouWishToAsk'];?>
				</div>
			</div>
		</div>*/?>
		<?php if($indusrty=='news' || $indusrty=='reviews'){?>
		<div class="row" id="DonationRow" >
			<div class="cell label_wrapper"><label><?php echo $label['donation'];?></label></div>
			<!-- Day -->
			<div class="cell frm_element_wrapper mt5">
				<div class="cell defaultP">
					<?php echo form_input($projDonations);?>
				</div>
				<div class="cell">
				  <?php echo $label['doYouWishToAsk'];?>
				</div>
			</div>
		</div>	
			<?php } ?>
				
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $label['originalLanguage'];?></label></div>
				<div class="cell frm_element_wrapper">
						<?php
							$projLanguage=set_value('projLanguage')?set_value('projLanguage'):@$LID->projLanguage;
							$language = getlanguageList();
							echo form_dropdown('projLanguage', $language, $projLanguage,'id="projLanguage" class="required NumGrtrZero" title="'.$this->lang->line('thisFieldIsReq').'"');
						?>
				</div>
			</div>
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $label['producedInCountry'];?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<?php
						$producedInCountry=set_value('producedInCountry')?set_value('producedInCountry'):@$LID->producedInCountry;
						$producedInCountryList = getCountryList();
						echo form_dropdown('producedInCountry', $producedInCountryList, $producedInCountry,'id="producedInCountry" class="required"');
					?>
				</div>
			</div>

			<div class="row">
				<div class="cell label_wrapper"><label><?php echo $label['releaseDate'];?></label></div>
				<!-- Day -->
				<div class="cell frm_element_wrapper">
					<div class="cell"><?php echo form_input($projReleaseDate); ?></div>
					<div class="cell pl5 pt5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#projReleaseDate").focus();' /> </div>
					<div class="row wordcounter"><?php echo form_error($projReleaseDate['name']); ?></div>
				</div>
			</div>
			
			
		
		<?php
			if($indusrty=='filmNvideo'){?>	
			
				<div class="row">
					<div class="cell label_wrapper"><label><?php echo $label['classification'];?></label></div>
					<!-- Day -->
					<div class="cell frm_element_wrapper">
						<?php echo form_input($classification); ?>
						<div class="row wordcounter"><?php echo form_error($classification['name']); ?></div>
					</div>
				</div>
				
				<div class="row">
					<div class="cell label_wrapper"><label><?php echo $label['classifiedBy'];?></label></div>
					<!-- Day -->
					<div class="cell frm_element_wrapper">
						<?php echo form_input($classifiedBy); ?>
						<div class="row wordcounter"><?php echo form_error($classifiedBy['name']); ?></div>
					</div>
				</div>
				
				
				
				<div class="row">
					<div class="label_wrapper cell"><div class="lable_heading"><h1><?php echo $label['subTitles'];?></h1></div></div><!--label_wrapper-->
					<div class=" cell frm_element_wrapper"></div>
				</div>
				
				
				<div class="row">
					<div class="cell label_wrapper"><label><?php echo $label['language1'];?></label></div>
					<!-- Day -->
					<div class="cell frm_element_wrapper">
						<?php
							$projSubtitle1=set_value('projSubtitle1')?set_value('projSubtitle1'):@$LID->projSubtitle1;
							//$language = getlanguageList();
							echo form_dropdown('projSubtitle1', $language, $projSubtitle1,'id="projSubtitle1" class="projSubtitle1"');
						?>
						<?php //echo form_input($projSubtitle1); ?>
					</div>
				</div>
				
				<div class="row">
					<div class="cell label_wrapper"><label><?php echo $label['language2'];?></label></div>
					<div class="cell frm_element_wrapper">
						 <?php
							$projSubtitle2=set_value('projSubtitle2')?set_value('projSubtitle2'):@$LID->projSubtitle2;
							//$language = getlanguageList();
							echo form_dropdown('projSubtitle2', $language, $projSubtitle2,'id="projSubtitle2" class="projSubtitle2"');
						?>
						 <?php // echo form_input($projSubtitle2); ?>
					</div>
				</div>
				
				<div class="row">
					<div class="label_wrapper cell"><div class="lable_heading"><h1><?php echo $label['dubbing'];?></h1></div></div><!--label_wrapper-->
					<div class=" cell frm_element_wrapper"></div>
				</div>

				<div class="row">
					<div class="cell label_wrapper"><label><?php echo $label['language1'];?></label></div>
					<!-- Day -->
					<div class="cell frm_element_wrapper">
						<?php
							$projDubbing1=set_value('projDubbing1')?set_value('projDubbing1'):@$LID->projDubbing1;
							//$language = getlanguageList();
							echo form_dropdown('projDubbing1', $language, $projDubbing1,'id="projDubbing1" class="projDubbing1"');
						?>
						<?php // echo form_input($projDubbing1); ?>
					</div>
				</div>

				<div class="row">
					<div class="cell label_wrapper"><label><?php echo $label['language2'];?></label></div>
					<div class="cell frm_element_wrapper">
						<?php
							$projDubbing2=set_value('projDubbing2')?set_value('projDubbing2'):@$LID->projDubbing2;
							//$language = getlanguageList();
							echo form_dropdown('projDubbing2', $language, $projDubbing2,'id="projDubbing2" class="projDubbing2"');
						?>
						<?php //echo form_input($projDubbing2); ?>
					</div>
				</div>
				<?php
			}
			?>
			
		<!--add Sales section in bottom-->
		
			
		<?php if(!($indusrty=='news' || $indusrty=='reviews')){?>
			<div class="row">
				<div class="label_wrapper cell"><div class="lable_heading"><h1><?php echo $label['project_sales'];?></h1></div></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper"></div>
			</div>
		
			<div class="row">
			<div class="cell label_wrapper"> <label class="select_field"><?php echo $label['salesInformation'];?></label></div>
			<div class="cell frm_element_wrapper">
				<div class="row pt5">
				<?php
					$projSellstatus=set_value('projSellstatus')?set_value('projSellstatus'):@$LID->projSellstatus;
					$projSellType=set_value('projSellType')?set_value('projSellType'):@$LID->projSellType;
					$sellPriceType=set_value('sellPriceType')?set_value('sellPriceType'):@$LID->sellPriceType;
					$checked='checked';
					$dn='';
					if($projSellstatus == 't'){
						$dn = 'dn';
						$checked = '';
					}
					
				/*if(isset($LID->projSellstatus) && !empty($LID->projSellstatus)){
					if($LID->projSellstatus=='t') {
						$pricingOption = $label['sell'];
						$sellTypeDisplay = '';
					} else {
						$pricingOption = $label['free'];
						$sellTypeDisplay = 'dn';
					}
					?>
					<div class="cell frm_element_wrapper mH20">
						<div class="row mt-5 ml-20">
							<div class="orange fmoss pt2"><?php echo $pricingOption;?></div>
						</div>	
					</div>
					<?php 
				}else {
					$sellTypeDisplay = 'dn';*/
					//Add display for not stable labels
					if($LID->projSellstatus=='t') {
						$sellTypeDisplay = '';
					} else {
						$sellTypeDisplay = 'dn';
					}
					?>
				<div class="cell defaultP" onClick="$('#DonationRow').hide();$('#sellOptionRow').show();">
					<input type="radio" id="projSellstatus" name="projSellstatus" <?php if($projSellstatus=='t') echo 'checked';?> value="t" />
				</div>
				
				<div class="cell mr8">
					<label class="lH25"><?php echo $label['sell'];?></label>
				</div>
				
				<div class="cell defaultP " onclick="$('#DonationRow').show();$('#sellOptionRow').hide();$('#sellPriceCollection').hide();">
					<input type="radio" id="projSellstatusf" name="projSellstatus" <?php echo $checked;?> value="f" />
				</div>
				
				<div class="cell">
					<label class="lH25"><?php echo $label['free'];?></label>
				</div>
			<?php //}?>
			</div>
			<div class="row f11 pt5">
				<?php echo $this->lang->line('yourSellerSetting1').'<a href="'.base_url('dashboard/globalsettings').'" class="ptr dash_link_hover">'.$this->lang->line('yourSellerSetting2').'</a>'.$this->lang->line('yourSellerSetting3');?>
			</div>
			</div>
			</div>
		<?php
		$displayDonation=$dn;
		?>
		
		<div class="row <?php echo $displayDonation;?>" id="DonationRow" >
			<div class="cell label_wrapper"><label><?php echo $label['donation'];?></label></div>
			<!-- Day -->
			<div class="cell frm_element_wrapper mt5">
				<div class="cell defaultP">
					<?php echo form_input($projDonations);?>
				</div>
				<div class="cell">
				  <?php echo $label['doYouWishToAsk'];?>
				</div>
			</div>
			
			<!--<div class="row f11">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<!--<div class=" cell frm_element_wrapper mt-16">
					<?php //echo $this->lang->line('viewFreeMedia');?>
				</div>	
			</div>-->	
		</div>
		<?php }?>
		<!-- sell type  radio option-->
		<div class="row <?php echo $sellTypeDisplay;?>" id="sellOptionRow">
			<div class="cell label_wrapper"> <label class="select_field"><?php echo 'Sell Type';?></label></div>
			<div class="cell frm_element_wrapper">
				<div class="row pt5">
					<div class="cell defaultP">
						<input type="radio" id="projSellType" name="projSellType" <?php if($projSellType==1 || empty($projSellType)) echo 'checked';?> value="1" />
					</div>
						
					<div class="cell mr8">
						<label class="lH25"><?php echo $label['setPrice'];?></label>
					</div>
					
					<div class="cell defaultP" onclick="$('#sellPriceCollection').hide();">
						<input type="radio" id="projSellTypeAuction" name="projSellType" <?php if($projSellType==2) echo 'checked';?> value="2" />
					</div>
					
					<div class="cell">
						<label class="lH25"><?php echo $label['auction'];?></label>
					</div>
				</div>	
			</div>
		</div>
		<!-- sell type  radio option-->
		<?php 
		if($LID->category=="Collection" && $projSellstatus=='t' && $projSellType==1) {
			$priceTypeDisplay = '';
		}else{
			$priceTypeDisplay = 'dn';
		}
		?>
		<!-- sell price collection radio option-->
		<div class="row <?php echo $priceTypeDisplay;?>" id="sellPriceCollection">
			<div class="cell label_wrapper"> <label class="select_field"><?php echo 'Price Type';?></label></div>
			<div class="cell frm_element_wrapper">
				<div class="row pt5">
					<div class="cell defaultP">
						<input type="radio" id="priceForCollection" name="sellPriceType" <?php if($sellPriceType==1 || empty($sellPriceType)) echo 'checked';?> value="1" />
					</div>
						
					<div class="cell mr8">
						<label class="lH25"><?php echo $label['priceForCollection'];?></label>
					</div>
					
					<div class="cell defaultP ">
						<input type="radio" id="priceForCollectionNPiece" name="sellPriceType" <?php if($sellPriceType==2) echo 'checked';?> value="2" />
					</div>
					
					<div class="cell">
						<label class="lH25"><?php echo $label['priceForCollectionNPiece'];?></label>
					</div>
				</div>	
			</div>
		</div>
		<!-- sell price collection radio option-->
		
		<!--add Sales section in bottom-->
		
		
			<div class="seprator_25 clear row"></div>
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
					 <?php
						echo form_input($projectid);
						if(isset($LID->projectid) && !empty($LID->projectid)){
							$button=array('save');
						}else{
							$button=array('save','cancelForm');
						}
						$this->load->view("common/button_collection",array('button'=>$button)); 
					 ?>
					 <div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
					<?php if($indusrty=='photographyNart'){?>
						 <div class="row">
							 <div class="cell">*&nbsp;</div>
							 
							 <div class="cell width545px"><?php echo $this->lang->line('newWatermarksMsg');?></div>
						 </div><?php
					}
					?>
					<?php if($indusrty=='musicNaudio'){?>
						 <div class="row">
							 <div class="cell">*&nbsp;</div>
							 
							 <div class="cell width545px"><?php echo $this->lang->line('musicNaudioDescMsg');?></div>
						 </div><?php
					}
					?>
				</div>
			</div>
		<?php echo form_close(); ?>
		
		<div class="seprator_25 clear row"></div>
	</div>
</div>
<!-- Set industry type-->
<?php 
	if(isset($indusrty) && !empty($indusrty)){ 
		$industryType = $indusrty;
	}else{
		$industryType = '';
	}?>
<script type="text/javascript">
function calcelForm()
	{
		var industry = '<?php echo $industryType;?>';
		location.href=baseUrl+language+"/media/"+industry;
	}
	
$(document).ready(function(){
	//Function load when project type sell selected
	$('#projSellstatus').click(function(){
		projectStyle = $("input[type='radio'][name='projCategory']:checked").val();
		var projectStyleType = $("#"+projectStyle).html();
		projCategory = $('#projCategoryDiv').html();
		if($('#projSellType').is(':checked') === true && (projectStyleType == "Collection" || projCategory == "Collection")) {
			$('#sellPriceCollection').show();
		}else{
			$('#sellPriceCollection').hide();
		}
	});
	
	//Function to manage sell pricing on category change
	$('.projectCategory').click(function(){
		projectStyle = $("input[type='radio'][name='projCategory']:checked").val();
		var projectStyleType = $("#"+projectStyle).html();
		if(projectStyleType == "Collection" && $('#projSellstatus').is(':checked') === true && $('#projSellType').is(':checked') === true) {
			$('#sellPriceCollection').show();
		}else{
			$('#sellPriceCollection').hide();
		}
	});
	
	//Function load when project type sell selected
	$('#projSellType').click(function(){
		projectStyle = $("input[type='radio'][name='projCategory']:checked").val();
		
		var projectStyleType = $("#"+projectStyle).html();
		projCategory = $('#projCategoryDiv').html();
		if($('#projSellType').is(':checked') === true && (projectStyleType == "Collection" || projCategory == "Collection")) {
			$('#sellPriceCollection').show();
		}else{
			$('#sellPriceCollection').hide();
		}
	});
	
	
	<?php if($LID->category=="Collection" && $projSellstatus=='t') {?>
		if($('#projSellstatus').is(':checked') === true) {
			$('#sellOptionRow').show();
			if($('#projSellType').is(':checked') === true) {
				$('#sellPriceCollection').show();
			}else{
				$('#sellPriceCollection').hide();
			}
		}
	<?php }else{ ?>
		if($('#projSellstatus').is(':checked') === true) {
			$('#sellOptionRow').show();
		}
	<?php }?>
});	
</script>
	
	
