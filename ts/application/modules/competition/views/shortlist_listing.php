<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 $shortListDataCount=count($shortListData);
 if($shortListData && is_array($shortListData) && $shortListDataCount > 0){
		
		for($i=0;$i<count($shortListData);$i++) {
			
			$userCoverImage='';
			$userdefCoverImage=$this->config->item('defaultcompetitonEntryImg180X210'); 
			$userCoverImage = addThumbFolder($shortListData[$i]['coverImage'], '_m');	
			$imgSrc = getImage($userCoverImage,$userdefCoverImage);
			
			// competition data 
			$currentDate = strtotime(date("Y-m-d"));
			$createdDate = strtotime($shortListData[$i]['createdDate']);
			$submissionStartDate = strtotime($shortListData[$i]['submissionStartDate']);
			$submissionEndDate = strtotime($shortListData[$i]['submissionEndDate']);
			$votingStartDate = strtotime($shortListData[$i]['votingStartDate']);
			$votingEndDate = strtotime($shortListData[$i]['votingEndDate']);
			$roundType = $shortListData[$i]['competitionRoundType'];
			$roundTypeLable = $this->lang->line('userCompetitionRound1');// set current round type
			$onGoingRound='1';// set current going round
			if($roundType==2){
				
				if($votingEndDate <= $currentDate){
					$submissionStartDate = strtotime($shortListData[$i]['submissionStartDateRound2']);
					$submissionEndDate = strtotime($shortListData[$i]['submissionEndDateRound2']);
					$votingStartDate = strtotime($shortListData[$i]['votingStartDateRound2']);
					$votingEndDate = strtotime($shortListData[$i]['votingEndDateRound2']);
					$roundTypeLable = $this->lang->line('userCompetitionRound2');// set current round type
					$onGoingRound='2';// set current going round
				}
			}
			// get loggedin userId
			$userId = (isLoginUser())?isLoginUser():0;
			if($userId){
				$actionFunction = "voteInsert('".$userId."','".$shortListData[$i]['competitionId']."','".$shortListData[$i]['competitionEntryId']."')";
			}else{	
				$beforeSortlistLoggedIn = $this->lang->line('compeEntriesVoteLoggedInMsg');
				$actionFunction = "openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeSortlistLoggedIn."')";
			}
			?>
	
				<div class="ver_contact_wp_big" id="uncrave_<?php echo $i ?>">
				<div class="ptr" onclick="gotourl('',1);">
					<div class="crave_admin_user_pic_wp">
							<img class="max_w_89 max_h_59" src="<?php echo $imgSrc;?>" />
					</div><!--ver_contact_user_pic_box-->
					<div class="crave_admin_user_data">
							<span class="orange_color crave_data_heading1 gray_clr_hover"><?php echo getSubString($shortListData[$i]['title'],30);?></span>
							<span class="crave_data_heading3"><?php echo getSubString($shortListData[$i]['onelineDescription'],70);?></span>
					</div><!--crave_admin_user_data-->
				</div>
		<?php if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate ) { ?>
		<div class="crave_admin_divider"></div>
		<div class="tds-button-big mt28">
			<a href="javascript:void(0)" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" onclick="<?php echo $actionFunction;?>"><span>Vote</span></a>
		</div>
		<?php }?>
				</div><!--ver_contact_wp-->
	
			<?php	}
		
			if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
				 <div class="row">
					<div class="cell width_569  pagingWrapper">
						<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/competition/shortlist/'),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
					</div>
						<div class="clear"></div>
				</div>
			<?php
				}
			}else{
				echo '<div class="mt20 b black pl20 pr20">'.$this->lang->line('noRecordFound').'</div>';
			}?>

<script type="text/javascript">
	function voteInsert(val1,val2,val3) {
		fromData = {
					userId:val1,
					competitionId:val2,
					competitionEntryId:val3
				}
				$.post(baseUrl+language+'/competition/competitionvoteinsert',fromData, function(data) {
					if(data){
						customAlert(data.msg);
					} 	
				},"json");
	}
</script>
