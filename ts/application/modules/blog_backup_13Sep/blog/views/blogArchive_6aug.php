<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
if($showFlag==0)
{
	echo anchor('javascript://void(0);','<h1> <span class="formTip" title="'.$label['archives'].'">'.$label['archives'].'</span></h1>',array('class'=>'go',
	'onclick'=>"AJAX('".base_url(lang().'/blog/categoryPosts')."','postsInfo','".encode($blogId)."','0');"));		
}
else
{
	echo anchor('javascript://void(0);','<h1> <span class="formTip" title="'.$label['archives'].'">'.$label['archives'].'</span></h1>',array('class'=>'formTip go',
	'onclick'=>"AJAX('".base_url(lang().'/blog/frontCategoryPosts')."','frontPostsInfo','".encode($blogId)."','0');"));			
}
?>
<ul>
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
					
					if ($recordCounter == 13) break; //Making one more than 12 months to making out put correct
					$recordCounter++;
						
					$monthName = date("F", mktime(0, 0, 0, ($rowMonths['month']+1),0,0));
												
						echo '<li>';	
						echo '<div class="row">';								
							echo '<div class="cell">';									
							//CALLING AJAX TO LOAD DATA IN DIVID "POSTINFO"
								if($showFlag==0)
								{
									
									echo anchor('javascript://void(0);',$row['yearextracted'].' '.$monthName,array('class'=>'formTip go',
									'title'=>$row['yearextracted'].' '.$monthName,
									'onclick'=>"AJAX('".base_url(lang().'/blog/previewArchive')."','postsInfo','".encode($rowMonths['month'])."','".encode($row['yearextracted'])."','".encode($blogId)."');"));
									/*echo anchor('javascript://void(0);',$row['yearextracted'].' '.$monthName.' ('.$rowMonths['postcount'].')',array('class'=>'formTip',
									'title'=>$label['categories'],
									'onclick'=>"AJAX('".base_url(lang().'/blog/previewArchive')."','postsInfo','".encode($rowMonths['month'])."','".encode($row['yearextracted'])."');"));*/
							   }
							   else
							   {
							  
								echo anchor('javascript://void(0);',$row['yearextracted'].' '.$monthName,array('class'=>'formTip go',
								'title'=>$row['yearextracted'].' '.$monthName,
								'onclick'=>"AJAX('".base_url(lang().'/blog/frontArchivesPost')."','frontPostsInfo','".encode($rowMonths['month'])."','".encode($row['yearextracted'])."','".encode($blogId)."');"));
							   }
							echo '</div>';
									
						echo '</div>';			
						echo '</li>';			
				}			 
		}//END MAIN FOREACH LOOP
			
	}
	else echo '<div>No Archives</div>';
?>
</ul>
