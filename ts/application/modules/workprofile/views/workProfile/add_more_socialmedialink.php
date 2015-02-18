<?php
$socialLinkArr = array(
	'name'	=> 'socialLink',
	'id'	=> 'socialLink',
	'value'	=> $socialLink,
	'size'	=> 30,
	'class'       => 'BdrCommon width246px required',

);

$socialLinkTypeArr = array(
	'name'	=> 'profileSocialLinkType',
	'id'	=> 'profileSocialLinkType',
	'class'       => 'frm_Bdr',
	'title' =>  $label['socialLinkType'],
);
$optionsSocialLinkType = array(
	'' => 'Select Option',
	'1' => 'Toad Square',
	'2' => 'Facebook',
	'3' => 'Twitter',
	'4' => 'Linkedin',
	'5' => 'Other',
);
$socialLinkDesc  = array(
	'name'	=> 'socialLinkDesc',
	'value'	=> set_value('socialLinkDesc'),
	'id'	=> 'socialLinkDesc',
	'class'       => 'frm_Bdr',
	'rows' => 3,
	'cols' => 25,
	'style' =>'height:65px',
);
$mode  = array(
	'name'	=> 'mode',
	'value'	=> $mode,
	'id'	=> 'mode',
	'type'  => 'hidden',
	
);

?>
		
<?php //echo "<pre>"; print_r($socialMediaIconList);
	$attributes = array('name' => 'customForm', 'id' => 'customForm');
	echo form_open('workprofile/addMoreSocialLinks',$attributes);
	echo form_hidden('workProfileId',$workProfileId);
	echo form_input($mode);
?>
<input type="hidden" name="profileSocialLinkId" id="profileSocialLinkId" value="0" />
<?php /*
<div class="row">
	<div class="label_wrapper cell"><div class="lable_heading"><h1><span id="socialMediaLinkTitle"><?php echo $label['add'];?></span> <?php echo $label['socialLink'];?></h1></div></div>
	
</div><!--row-->
*/
?>	
<div class="row form_wrapper">	
	<div class="row">
		<div class="label_wrapper cell">
			<label  class="select_field"><?php echo $label['socialLinkType']; ?></label>
		</div><!--label_wrapper-->
		<?php 
				$socialLinkTypeName = 'profileSocialLinkType';
				if($mode=='edit')
					$socialLinkTypeval = $profileSocialLinkType;
				else
					$socialLinkTypeval ='';
					
		?>
		<div class="cell frm_element_wrapper">			
			<?php	
			
				$attr = 'id ="socialLinkType" class="required error"';
				echo form_dropdown($socialLinkTypeName, $socialMediaIconList, $socialLinkTypeval, $attr);
				echo form_error($socialLinkTypeName); 
				
			?>
		</div>
		
	</div><!--from_element_wrapper-->
	<div class="seprator_5 cell"></div>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label  class="select_field"><?php echo $label['socialLink']; ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<?php echo form_input($socialLinkArr);?>
		</div>
	</div><!--from_element_wrapper-->
	
	<?php echo form_hidden('save','Save');?>
		
	<div class="row ">
		<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
			<div class="cell frm_element_wrapper">
			<div class="cell Fleft">
				<div class="Req_fld cell"><?php echo $label['requiredFields'];?></div><!--Req_fld-->				
			</div>
			
			<div class="fr">					
				<?php
					$button=array('save','cancelHide');
					echo Modules::run("common/loadButtons",$button); 
				?>				
			</div>
		</div>	
	</div>
	

<?php echo form_close(); ?> 
</div>
<div class="cell pagingWrapper"></div>


