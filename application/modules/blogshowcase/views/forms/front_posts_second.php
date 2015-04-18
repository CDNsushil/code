<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	$currentMethod = $this->router->method;
	$flag = 0;
	$postresultCount = 0;

	foreach($postResults as $row)
	{	
		if(($postresultCount+2)%2==1) {
						
			//echo '<pre />';print_r($row);
			if(LoginUserDetails('user_id') == $row->custId) $flag = 1; //give visiblity to edit delete button only if the post is posted by loggen in user
			else $flag=0;

			$postYear = date('Y',strtotime($row->dateCreated)); 	
			$postDate = date('d',strtotime($row->dateCreated)); 	
			$postMon = date('M',strtotime($row->dateCreated)); 	
							
			// get post image
			$postImagePath = getBlogImage($row,0,'_l');
			$postMediaSrc = '<img class="maxWidth165px maxHeight120px ma"  src="'.$postImagePath.'" />';						
			$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$row->custId.'/'.$row->postId.'/frontPostDetail':'/blogshowcase/frontPostDetail/'.$row->custId.'/'.$row->postId;
			$href=base_url(lang().$href);	
			
			$LogSummarywhere=array(
			'entityId'=>$entityId,
			'elementId'=>@$row->postId
			);
			$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount,reviewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
			if($resLogSummary)
			{
				$resLogSummary=$resLogSummary[0];
				$viewCount=$resLogSummary->viewCount;
				$craveCount=$resLogSummary->craveCount;
				$ratingAvg=$resLogSummary->ratingAvg;
				$reviewCount = $resLogSummary->reviewCount;
			} else {
				$viewCount=0;
				$craveCount=0;
				$ratingAvg=0;
				$reviewCount = 0;
			}
			
			$ratingAvg=roundRatingValue($ratingAvg);
								
			$ratingImg=base_url('images/rating/rating_0'.$ratingAvg.'.png');
			$cravedALL='';
			$loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$where = array(
							'tdsUid'=>$loggedUserId,
							'entityId'=>$entityId,
							'elementId'=>@$row->postId
						);
				$countResult = countResult('LogCrave',$where);
				$cravedALL = ($countResult>0)?'cravedALL':'';
			}else
			{
				$cravedALL='';
			}
			?>	
			
			<div class="cnt_box widht_300  bg_fff mb15 bdr_d7d7 ptr  " onclick="window.location.href='<?php echo $href;?>'">
				<div class="clearb pl20 pt25  pr8">
					<h4 class="fs22 pb10 opensans_semi lineH27"> <?php echo getSubString($row->postTitle,50);?></h4>
					<div class="head_list fl pt10 pr20">
						<div class="icon_view3_blog fs11 icon_so"><?php echo $viewCount;?></div>
						<div class="icon_crave4_blog fs11 icon_so"><?php echo $craveCount;?></div>
						<div class="rating fl pt6"> <img src="<?php echo $ratingImg;?>" alt="" class="max_w29" /></div>
						<div class="btn_share_icon fs11 icon_so"><?php echo $reviewCount;?></div>
					</div>
				</div>
				<div class="sap_15"></div>
				<div class="display_table clearb ">
					<div class="display_table m_auto">
						<div class="table_cell"><?php echo $postMediaSrc; ?></div>
					</div>
					<div class="pl20 pr20 pt10  clearb">
						<p class="fs13"> <?php echo $postMon.' '.$postDate; ?>, <span class="red"><?php echo $postYear;?></span></p>
						<div class="sap_25"></div>
						<div class="open_sans lineH20 text_cnt fs15 pb20">
							<p>
								<?php echo getSubString($row->postOneLineDesc,130,'...'); ?>	
							</p>
						</div>
						<a href="<?php echo $href;?>">
							<button class="red fr opensans_semi"> Continue Reading</button>
						</a>
						<div class="sap_25"></div>
					</div>
				</div>
			</div>
		<?php	
		}
		$postresultCount++;
	}	
	 //End For
	?>
	<!-- sub_col_middle  global -->	
<!--cell width_476 sub_col_1 mr11 -->
