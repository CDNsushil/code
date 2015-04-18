<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(isset($usersList) && is_array($usersList)  && count($usersList) > 0 ){
		foreach ($usersList as $userData){ 
			$creative=$userData->creative;
			$associatedProfessional=$userData->associatedProfessional;
			$enterprise=$userData->enterprise;
			
			$receiverName = $userData->firstName.' '. $userData->lastName;

			$getUserShowcase = showCaseUserDetails($userData->tdsUid);
			
			$isShowcaseCreated=true;
			
			if($crave->isPublished != 't'){
				$isShowcaseCreated=false;
				$imageType=$this->config->item('defaultMemberImg_xxs');
				$memberType='Member';
			}
			elseif($creative == 't'){
				$imageType=$this->config->item('defaultCreativeImg_xxs');
				$memberType='Creative';
			}elseif($associatedProfessional ==  't'){
				$imageType=$this->config->item('defaultAssProfImg_xxs');
				$memberType='Associated Professional';
				
			}elseif($enterprise == 't'){
				$imageType=$this->config->item('defaultEnterpriseImg_xxs');
				$receiverName = $crave->enterpriseName;
				$memberType='Enterprise';
				
			}else{
				$isShowcaseCreated=false;
				$imageType=$this->config->item('defaultMemberImg_xxs');
				$memberType='Member';
				
			}
			
			if($getUserShowcase['userImage']!='') {
			 $userImage=$getUserShowcase['userImage'];
			}
			$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$imageType);  	
			$userImage=getImage($userImage,$imageType);	
			?>

			<a href="javascript://void(0)" onclick ="addCollaborationUser('<?php echo $userData->tdsUid ?>','<?php echo $receiverName ?>');" >		
			<div class="search_result_list_wrapper ml2 bg_SRCreative mb10 minH60">
			<div class="bg_white pt2 pb2 pl2 pr2">
			<div class="bg_3e3e3e minH60">
			<div class="fl width_126 bdrR_fff height_60">
			<div class="cell recent_thumb_PApage thumb_absolute01">
			<div class="AI_table">
			<div class="AI_cell"> <img class="mH30 bdr_cecece max_w34_h41" src="<?php echo $userImage ?>"></div>
			</div>
			</div>
			</div>
			<div class="fl width_427 ml2">
			<div class="bdr_f15921 font_opensansSBold clr_white ml12 mr17 pt3 pb3">
			<div class="fl font_size14 width250px"><?php echo $receiverName ?></div>
			<div class="fr font_size12"><?php echo $memberType; ?></div>
			<div class="clear"></div>
			</div>

			<div class="seprator_7"></div>
			</div>
			</div>
			</div>
			</div>
			</a>		 
			<?php 
		}
		
		if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?>
			<div class="pt15 ml28 mt7 mr15">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/collaboration/getToadUsers/'),"divId"=>"showUsersList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
			</div>
			<div class="seprator_40"></div>
			<div class="clear"></div>
			<?php 
		} 
	} else { ?>	

	<div class="nocravebg nocravbg_commonshedow ml10"> 
	<div class="nocravebg_inner">
	<div class="font_opensansSBold font_size24 clr_f1592a bdrB_878688 width_267 mt22 ml160">No Record Found</div>
	</div>

	<div class="nocravebg_btm">
	</div>
	</div>

	<?php } ?>

