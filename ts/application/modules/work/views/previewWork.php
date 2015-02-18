<span class="clear_seprator "></span>
	<div class="title-content width520px">
		<div class="title-content-left">
			<div class="title-content-right">
				<div class="title-content-center">
					<div class="title-content-center-label"><?php echo $label['workInformation']?> </div>
					<div class="tds-button-top"></div><!-- End tds-button-top-->
				<div class="clearfix"></div>
				</div><!-- End title-content-center-->
			</div><!-- End title-content-right-->
		</div><!-- End title-content-left-->
	</div><!-- End title-content-->
	<div class="width500px">
<?php if(count($work) > 0){	?>
		<div class="orng lh16"><?=$label['workTitle'];?>:</div>
		<div class="cell pop_right_text" ><?=$work->workTitle;?></div>
		<span class="clear_seprator "></span>
		
			<div class="cell orng lh16 "><?=$label['workOneLineDesc'];?>:</div>
			<div class="cell pop_right_text" ><?=$work->workShortDesc;?></div>
		
		<span class="clear_seprator "></span>
		
			<div class="cell orng lh16"><?=$label['workTagWords'];?>:</div>
			<div class="cell pop_right_text" ><?=$work->workTag;?></div>
		<span class="clear_seprator "></span>
		
		<div class="cell orng lh16"><?=$label['workDesc'];?>:</div>
			<div class="cell pop_right_text" ><?=$work->workDesc;?></div><span class="clear_seprator "></span>
		
		<div class="orng lh16"><?=$label['workCountry'];?>:</div>
		<div class="cell pop_right_text" ><?php 
			 if($work->workCountryId =='') echo $label['noCountrySelected'].":";
			 else //echo $work->workCountryId;
			 echo getCountry($work->workCountryId);
		 ?>
		 </div>
		 <span class="clear_seprator "></span>
		<div class="orng lh16"><?=$label['workLang1'];?>:</div>
		<div class="cell pop_right_text" ><?php 
			 if(!isset($work->workLang1) || $work->workLang1 ==0) echo $label['noLanguageSelected'];
			 else echo getLanguage($work->workLang1);
		 ?></div>
		 <span class="clear_seprator "></span>
		<div class="orng lh16"><?=$label['workLang2'];?>:</div>	
		<div class="cell pop_right_text" ><?php 
			 if(!isset($work->workLang2) ||$work->workLang2 ==0) echo $label['noLanguageSelected'];
			 else //echo $work->workLang2;
			 echo getLanguage($work->workLang2);
		 ?></div>
		 <span class="clear_seprator "></span>
		<div class="orng lh16"><?=$label['workLang3'];?>:</div>
		<div class="cell pop_right_text" ><?php 
			 if(!isset($work->workLang3) ||$work->workLang3 ==0) echo $label['noLanguageSelected'].":";
			 else echo getLanguage($work->workLang3);
		 ?></div>
		 <span class="clear_seprator "></span>
		<div class="orng lh16"><?=$label['workRemuneration'];?>:</div><?=$work->workRemuneration;?><span class="clear_seprator "></span>
		
		<div class="cell" ><?php 
			 if($work->workRecommendation !=''){
				echo '<div class="orng lh16">'.$label['workRecommendation'].':</div>'.
				'<div class="cell pop_right_text" >'.$work->workRecommendation.'</div>';
			}
		 ?></div>
		<span class="clear_seprator "></span>
		<!--<div class="orng"><?=$label['workIndustry'];?>:</div><?=getIndustry($work->workIndustryId);?><span class="clear_seprator "></span>-->
		<div class="orng lh16"><?=$label['workUrgent'];?>:</div><div class="cell pop_right_text" ><?php echo $work->isUrgent == 't'?$label['yes']:$label['no'];?></div><span class="clear_seprator "></span>
		<div class="orng lh16"><?=$label['offerWorkExp'];?>:</div><div class="cell pop_right_text" ><?php echo $work->workExperiece == 't'?$label['yes']:$label['no'];?></div><span class="clear_seprator "></span>
		<span class="clear_seprator "></span>
	<?php

}
else{
echo $label['noWorkFound'];
} 
?>
</div>
