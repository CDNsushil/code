<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$showcaseId=loginUserDetails('showcaseId');?>
<div class="row">
	<div class="cell frm_heading">
		<h1><?php echo $this->lang->line('recommendations');?></h1>
	</div>
	<?php 		
		echo Modules::run("showcase/menuNavigation", $showcaseId); 
	?>
</div><!--row-end-->
<div class="seprator_5 row"></div>
<div class="row">
	<div class="btn_outer_wrapper fr width_auto pl5 mr14">
		<div class="fr">
			<div class="tds-button-big Fright">
				<a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/showcase/recommendations')?>"><span class="two_line"><?php echo $this->lang->line('recommendation');?><br><?php echo $this->lang->line('received');?></span></a> 
				<a style="background-position: 0px -95px;" href="javascript://void(0);"><span class="two_line" style="background-position: right -95px;" ><?php echo $this->lang->line('recommendation');?><br><?php echo $this->lang->line('given');?></span></a>
				
				
			</div>
		</div>
		<div class="clear"></div>
	 </div>
</div>
<div class="clear"></div>
<?php
$recommendationList= Modules::run("recommendations/index",array('from_userid'=>$userId)); 
if($recommendationList && is_array($recommendationList) && count($recommendationList)>0){
	?>
	<div class="row" id="pagingContent">
		  <?php 
		 
			foreach($recommendationList as $data){
	
				$getUserShowcase = showCaseUserDetails($data->to_userid);
				if(isset($data->to_userid) && !empty($data->to_userid))
				{
					$creative=$getUserShowcase['creative'];
					$associatedProfessional=$getUserShowcase['associatedProfessional'];
					$enterprise=$getUserShowcase['enterprise'];
					$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
					if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');
					if($getUserShowcase['userImage']!='') {
						 $userImage=$getUserShowcase['userImage'];
					}
					//echo $userImage;
					$userImage=addThumbFolder($userImage,$suffix='_xs',$thumbFolder ='thumb',$userDefaultImage);  	
					$userImage=getImage($userImage,$userDefaultImage);
				}else{
					$userImage = base_url().'images/var_user_img_default2.jpg';
				}
				
				//$userImage='media/'.$data->username.'/profile_image/'.$data->profileImageName;
				//$userImage=(($data->stockImageId>0)?$data->stockImgPath.'/'.$data->stockFilename:$userImage);
				//$userImage=getImage($userImage,'user');
				$showcaseLink=base_url(lang().'/showcase/index/'.$data->to_userid);
				$writerName=$data->firstName.' '.$data->lastName;
				$isisCheecked=$data->is_show_in_showcase=='t'?'checked':'';
				$isicCheecked=$data->is_show_in_cv=='t'?'checked':'';
				?>
				<div class="all_list_item ptr" onclick="gotourl('<?php echo $showcaseLink;?>',1);">
					<div class="recG_contact_wp_big pr minH120" id="row<?php echo $data->id;?>">
						<div class="crave_admin_user_pic_wp">
							<img class="max_w_89 max_h_59" src="<?php echo $userImage;?>">
						</div><!--ver_contact_user_pic_box-->
						<div class="rec_admin_user_data">
								<span class="orange_color crave_data_heading1"><?php echo getSubString($writerName,50);?></span>
								<span class="crave_data_heading2"><?php echo get_timestamp('F Y',$data->created_date) ;?></span>
								<span class="rec_data_heading3 overflow_inh"><?php echo nl2br(getSubString($data->recommendations,250));?></span>
						</div><!--crave_admin_user_data-->
					
						<div class="cell mr10 tds-button-top rec_del dn">
							<a title="Delete" href="javascript:void(0);" class="formTip ml6" onclick="deleteTabelRow('Recommendations','id',<?php echo $data->id;?>,'','','','','','','',1)" title="<?php echo $this->lang->line('delete');?>">
								<span><div class="projectDeleteIcon"></div></span>
							</a>
						</div>
					</div><!--ver_contact_wp-->
				</div>
			   <?php
			}
		  ?>
	</div>
	<?php
	if(count($recommendationList) >  10){?>
		<div class=" row  p15">
				<?php
					$this->load->view('pagination_view',array('totalRecord'=>count($recommendationList),'record_num'=>10));
				?>
		</div>
		<?php
	}
}else{
	/*
	<div class="row p15"><?php echo $this->lang->line('noRecord');?></div>
	*/
}
?>
<script>
	
	function recommendationsUpdate(obj){
		var fieldNmae=obj.name;
		var value = 'f';
		var id = obj.value;
		
		if(obj.checked){
			value = 't';
		}
		
		if(fieldNmae=='is_show_in_showcase'){
			var updateData={"is_show_in_showcase":value};
		}else{
			var updateData={"is_show_in_cv":value};
		}
		
		where={"id":id};
		var returnFlag=false;
		returnFlag=AJAX('<?php echo base_url(lang()."/recommendations/updaterecommendations");?>','',updateData,where);
		if(returnFlag){
			$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
			timeout = setTimeout(hideDiv, 5000);
		}
		runTimeCheckBox();
	}
</script>

