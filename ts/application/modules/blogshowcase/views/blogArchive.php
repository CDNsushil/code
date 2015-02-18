<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$currentMethod = $this->router->method;
$currentClass = $this->router->class;
$currentmonth = $this->uri->segment(5);
$currentyear = $this->uri->segment(6);
$currentMonthYear = $currentmonth.'select'.$currentyear;

$getarchiveYear = $archiveYearQuery->result_array();

if(isset($getarchiveYear) && is_array($getarchiveYear)) {
	$fetcharchiveMonths = FetchMonths($getarchiveYear[0]['yearextracted'],$userId,'model_blogshowcase');
	
} else {
	$fetcharchiveMonths = '';
}

if($archiveYearQuery->num_rows() > 0 && isset($fetcharchiveMonths) && !empty($fetcharchiveMonths)) 
{
	$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$userId.'/0/frontcatposts/':'/'.$currentClass.'/frontcatposts/'.$userId;
	$href=base_url(lang().$href);
	echo '<div class="row summery_right_archive_wrapper showcase_link_hover">';
	echo anchor($href,'<h1 class="sumRtnew_strip clr_white dash_link_hover">'.$label['archives'].'</h1>');

?>
<ul>
<?php 
$recordCounter=1;
	
		$temp = getdate();
		$year = $temp['year']; 			
		
		foreach($archiveYearQuery->result_array() as $row)
		{			
				$monthName='';
				
				foreach(FetchMonths($row['yearextracted'],$userId,'model_blogshowcase') as $rowMonths)
				{
					//$rowMonths['postcount']; //post count of the month
					//echo $rowMonths['month'].$row['yearextracted'];
					if(@$currentMonthYear== $rowMonths['month'].'select'.$row['yearextracted']) $addClass = " orange ";
					else $addClass = " clr_white ";
				
					if ($recordCounter == 13) break; //Making one more than 12 months to making out put correct
					$recordCounter++;
						
					$monthName = date("F", mktime(0, 0, 0, ($rowMonths['month']+1),0,0));
					$archivePostDetailResults['postResults'] = $this->model_blogshowcase->previewArchivesPost($rowMonths['month'],$row['yearextracted'],$userId);
					//echo '<pre />';print_r($archivePostDetailResults);
					$archivePostCount= count($archivePostDetailResults['postResults']);	
					
					$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$userId.'/'.$rowMonths['month'].'/frontArchivesPost/'.$row['yearextracted']:'/'.$currentClass.'/frontArchivesPost/'.$userId.'/'.$rowMonths['month'].'/'.$row['yearextracted'];
					$href=base_url(lang().$href);	
					 					
						echo '<li>';	
						//echo '<div class="row">';								
							
							//echo '<div class="cell">';		
							   	echo anchor($href,$row['yearextracted'].' '.$monthName.' ('.@$archivePostCount.')',array('class'=>$addClass));
							//echo '</div>';
									
						//echo '</div>';			
						echo '</li>';			
				}			 
		}//END MAIN FOREACH LOOP
			
	//}
	//else echo '<li><a href="javascript://void(0);" class="clr_white"><div>No Archives</div></a></li>';
?>
</ul>
<?php 
	echo '</div>';
} 
?>
