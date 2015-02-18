<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$indexLink='';
$module=$this->uri->segment(2);
$method=$this->uri->segment(3);
$last = $this->uri->total_segments();
$id = $this->uri->segment($last);
if(is_numeric($id) && $id > 0){
	
}else{
	$id = $this->uri->segment($last-1);
}

if($module=='media' && $id > 0){
	$indexLink=base_url(lang().'/media/'.$method.'/'.$id);
}
elseif($module=='upcomingprojects'){
	$indexLink=base_url(lang().'/'.$module.'/index');
}
else{
	
	$indexLink=getBackEndLink($entitytId,$elementId);
}

	$EEID=$elementId.$entitytId;
	$formName='ACF'.$EEID;?>
	<script>
	$(document).ready(function(){	
		$("#<?php echo $formName;?>").validate({
			  submitHandler: function() {
			   var crtId = $('#crtId<?php echo $EEID;?>').val();
			   var crtDesignation = $('#crtDesignation<?php echo $EEID;?>').val();
			   var crtName = $('#crtName<?php echo $EEID;?>').val();
			   var crtEmail = $('#crtEmail<?php echo $EEID;?>').val();
			   var elementId = '<?php echo $elementId;?>';
			   var entitytId = '<?php echo $entitytId;?>';
			   var divid='';
				if(crtId > 0){
					divid='rowData'+crtId;
				}else{
					divid='AssociativeData<?php echo $EEID;?>';
				}
				
			   var returnData = AJAX_json('<?php echo base_url(lang()."/creativeinvolved/addEditAssociative");?>',divid,crtId,crtDesignation,crtName,crtEmail,elementId,entitytId,'<?php echo $EEID;?>');
			   var addCreativeInvolvedLimit = '<?php echo $this->lang->line('addCreativeInvolvedLimit');?>';
			   addCreativeInvolvedLimit = parseInt(addCreativeInvolvedLimit); 
			   if(returnData.crtId==0 && returnData.countResult > addCreativeInvolvedLimit ){
				   customAlert('<?php echo $this->lang->line('addCreativeInvolvedLimit');?>');
			   }
			   $('#crtId<?php echo $EEID;?>').val(0);
			   $('#crtDesignation<?php echo $EEID;?>').val('<?php echo $this->lang->line('enterDesignation');?>');
			   $('#crtName<?php echo $EEID;?>').val('<?php echo $this->lang->line('enterName');?>');
			   $('#crtEmail<?php echo $EEID;?>').val('<?php echo $this->lang->line('enterEmail');?>');
			   $('#addEditIcon<?php echo $EEID;?>').attr('class','cat_smll_save_icon');
			   $('#cancelIcon<?php echo $EEID;?>').hide();
			   if($('#noRecord<?php echo $EEID;?>')){
					$('#noRecord<?php echo $EEID;?>').hide();
			   }
			 }
		});
	});
	</script>
	<?php
	$formAttributes = array(
		'name'=>$formName,
		'id'=>$formName
	);
	$crtDesignation = array(
		'name'	=> 'crtDesignation'.$EEID,
		'id'	=> 'crtDesignation'.$EEID,
		'class'	=> 'font_size11 width150px required',
		//'title'=>  $this->lang->line('enterDesignation'),
		'value'	=> '',
		'placeholder'	=> $this->lang->line('enterDesignation'),
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50,
		'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterDesignation')."','show')",
		'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterDesignation')."','hide')" 
	);
	$crtName = array(
		'name'	=> 'crtName'.$EEID,
		'id'	=> 'crtName'.$EEID,
		'class'	=> 'font_size11 width150px required',
		//'title'=>  $this->lang->line('enterName'),
		'value'	=> '',
		'placeholder'	=> $this->lang->line('enterName'),
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50,
		'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterName')."','show')",
		'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterName')."','hide')" 
	);
	$crtEmail = array(
		'name'	=> 'crtEmail'.$EEID,
		'id'	=> 'crtEmail'.$EEID,
		'class'	=> 'font_size11 width150px email',
		//'title'=>  $this->lang->line('enterEmail'),
		'value'	=> '',
		'placeholder'	=> $this->lang->line('enterEmail'),
		'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50,
		'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterEmail')."','show')",
		'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterEmail')."','hide')" 
	);
	$crtId = array(
		'name'	=> 'crtId'.$EEID,
		'id'	=> 'crtId'.$EEID,
		'value'	=> 0,
		'type'	=> 'hidden'
	);
?>

<div class="row">
	<div class="label_wrapper cell"><div class="lable_heading"><h1><?php echo $heading;?></h1></div></div><!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<?php echo form_open(base_url(lang().'/creativeinvolved/addAssociative'),$formAttributes); 
			echo form_input($crtId);
			?>
					<div class="cell mr5">
						<?php echo form_input($crtDesignation); ?>
					</div>
					<div class="cell mr5">
						<?php echo form_input($crtName); ?>
					</div>
					<div class="cell mr5">
						<?php echo form_input($crtEmail); ?>
					</div>
					<div class="cell pt5">
						
						<div class="small_btn dn mr0" id="cancelIcon<?php echo $EEID;?>" href="javascript:void(0)" onclick="cancelIcon(this)" EEID="<?php echo $EEID;?>">
							<a class="formTip" title="<?php echo $this->lang->line('cancel')?>" href="javascript:void(0)">
								<span>
									<div class="cat_smll_cancel_icon"></div>
								</span>
							</a>
						</div>
						<div class="small_btn mr0">
							<a class="formTip" title="<?php echo $this->lang->line('save')?>" href="javascript:void(0)" onclick="$('#<?php echo $formName;?>').submit();">
								<span>
									<div class="cat_smll_save_icon" id="addEditIcon<?php echo $EEID;?>" ></div>
								</span>
							</a>
						</div>
						
					</div>
		<?php echo form_close(); ?>
	</div>
</div><!--from_element_wrapper-->

<div class="row">
	<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
	<div class=" cell frm_element_wrapper">   
		<ul class="production_li_wp" id="AssociativeData<?php echo $EEID;?>">
			<?php
			$dn='';
			if($creativeInvolved){
				$dn='dn';
				foreach($creativeInvolved as $k=>$user){?>
					<li class="liData<?php echo $EEID;?>" id="row<?php echo $user->crtId;?>">
						<div id="rowData<?php echo $user->crtId;?>" class="pro_li_content_wp"> 
							<div class="cell pro_title"><?php echo $user->crtDesignation;?>&nbsp;</div>
							<div class="cell pro_name"><?php echo $user->crtName;?>&nbsp;</div>
							<div class="cell pro_name"><?php echo $user->crtEmail;?>&nbsp;</div>
							<div class="pro_btns"> 
								<div class="small_btn"><a  class="formTip" title="<?php echo $this->lang->line('delete')?>"  href="javascript:void(0)" onclick="deleteAssociative(this)" EEID="<?php echo $EEID;?>" crtId="<?php echo $user->crtId;?>"><div class="cat_smll_plus_icon"></div></a></div><!--small_cross_btn_wp-->
								<div class="small_btn"><a  class="formTip" title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editAssociative(this)" EEID="<?php echo $EEID;?>" crtId="<?php echo $user->crtId;?>" crtDesignation="<?php echo $user->crtDesignation;?>" crtName="<?php echo $user->crtName;?>" crtEmail="<?php echo $user->crtEmail;?>"><div class="cat_smll_edit_icon"></div></a></div><!--small_cross_btn_wp-->
							</div>
						</div>
					</li>
					<?php
				}
			}	?>	
		</ul>
		
	</div>
</div><!--row-->
<!--Add msg of invitation row-->
<div class="row">
		<div class="label_wrapper cell bg_none"></div>
		<div class="cell frm_element_wrapper">
			<div class="row">
				<div class="cell">*&nbsp;</div>
				<div class="cell width550px"> If a person you add here is a member of Toadsquare, and if you add their email address, you will be able to invite them, from the <a class="underline dash_link_hover" href="<?php echo $indexLink;?>">Index page</a>, to show a link to this work on their Showcase.</div>
			</div>
		</div>
	</div>
