<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$getarchiveYear = $archiveYearQuery->result_array();
if(isset($getarchiveYear) && is_array($getarchiveYear)) {
	$fetcharchiveMonths = FetchMonths($getarchiveYear[0]['yearextracted']);
} else {
	$fetcharchiveMonths = '';
}
	
if($archiveYearQuery->num_rows() > 0 && isset($fetcharchiveMonths) && !empty($fetcharchiveMonths)) {
	echo '<div class="clearbox pt10">';
	if($showFlag==0)
	{
		echo anchor('javascript://void(0);','<h4 class="red bb_F1592A fs16 font_bold pl10 pb5">'.$this->lang->line('archives').'</h4>',array('class'=>'go',
		//'title'=>$label['archives'],
		'onclick'=>"AJAX('".base_url(lang().'/blog/categoryPosts')."','postsInfo','".encode($blogId)."','0','".$isArchive."');"));		
	}
	else
	{
		echo anchor('javascript://void(0);','<h4 class="red bb_F1592A fs16 font_bold pl10 pb5">'.$this->lang->line('archives').'</h4>',array('class'=>'go',
		//'title'=>$label['archives'],
		'onclick'=>"AJAX('".base_url(lang().'/blog/frontCategoryPosts')."','frontPostsInfo','".encode($blogId)."','0');"));			
	}

?>
<ul class="pt20 pl18 pr20 date_list">
<?php 
$recordCounter=1;
	if($archiveYearQuery->num_rows() > 0)
	{	
		$temp = getdate();
		$year = $temp['year']; 
			
		
		foreach($archiveYearQuery->result_array() as $row)
		{			
				$monthName='';
				
				foreach(FetchMonths($row['yearextracted']) as $rowMonths)
				{
					
					// set active archive class
					$activeArchCls = '';
					
					if($archiveMonth == encode($rowMonths['month']) && $archiveYear == encode($row['yearextracted'])) {
						$activeArchCls = 'red';
					}
					
					if ($recordCounter == 13) break; //Making one more than 12 months to making out put correct
					$recordCounter++;
						
					$monthName = date("F", mktime(0, 0, 0, ($rowMonths['month']+1),0,0));
					$archivePostDetailResults['postResults'] = $this->model_blog->previewArchivesPost($rowMonths['month'],$row['yearextracted'],$blogId,$isArchive);
					$archivePostCount= count($archivePostDetailResults['postResults']);		
					// set no data cls for count 0
					$disableLi = '';
					if($archivePostCount==0) {
						$disableLi = ' greyClr';
					}		
						echo '<li class="'.$activeArchCls. $disableLi .'">';							
							//CALLING AJAX TO LOAD DATA IN DIVID "POSTINFO"
							if($archivePostCount==0)
							{						
								echo $monthName.' '.$row['yearextracted'].'<span class="greyClr fr">'.$archivePostCount.'</span>';
							}									
							else
							{	
								// set archived post list url
								$archivedPostsUrl = base_url_lang('blog/deletedposts/'.encode($rowMonths['month']).'/'.encode($row['yearextracted']));
								if($showFlag==0)
								{
									echo anchor($archivedPostsUrl,$monthName.' '.$row['yearextracted'].'<span class="red fr">'.$archivePostCount.'</span>');
							   }
							   else
							   {
							  	echo anchor('javascript://void(0);',$row['yearextracted'].' '.$monthName,array('class'=>'go',
								'onclick'=>"AJAX('".base_url(lang().'/blog/frontArchivesPost')."','frontPostsInfo','".encode($rowMonths['month'])."','".encode($row['yearextracted'])."','".encode($blogId)."');"));
							   }
							 }		
						echo '</li>';			
				}			 
		}//END MAIN FOREACH LOOP
			
	}
	else echo '<li><a href="javascript://void(0);"><div>No Archives</div></a></li>';
?>
</ul>
</div>
<div class="sap_45"></div>
<?php }?>
