<div><strong>Archives</strong> </div>
<?php 
	if($archiveYearQuery->num_rows() > 0){	
	$temp = getdate();
    $year = $temp['year']; 
			
		foreach($archiveYearQuery->result_array() as $row){
		if($row['yearextracted']!=$year){
		echo '<div>';echo $row['yearextracted'];	echo '</div>';	
			foreach(FetchMonths($row['yearextracted']) as $rowMonths)
			{
				echo '<div>';
				$monthName = date("F", mktime(0, 0, 0, $rowMonths['month']));
				echo anchor('blog/previewArchive/'.$rowMonths['month'].'/'.$row['yearextracted'], $monthName).'('.$rowMonths['postcount'].')';
				echo '</div>';				
			}
			}	else echo '<div>No Archives</div>';
		}
		
	}
	else echo 'No records';
?>
