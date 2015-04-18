<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

if(isset($activeEventId) && $activeEventId>0) $selectedEventId = $activeEventId;
else $selectedEventId = end($this->uri->segments);

$totalLiRecord = count(@$leftListData);

if($totalLiRecord<=0) {
	
		if(@$natureId == 2) { 
			 if($isArchive=='t'){
				 $mainLabelUrl = base_url(lang().'/event/events/deletedItems/');
			 }else{
				 $mainLabelUrl = base_url(lang().'/event/events/eventdetail/');
			 }
			
		}
		else if(@$natureId == 3) {
			 if($isArchive=='t'){
				 $mainLabelUrl = base_url(lang().'/event/launch/deletedItems/');
			 }else{
				$mainLabelUrl = base_url(lang().'/event/launch/launchdetail/');
			 }
			
		}
		else if(@$natureId == 4) { 
			if($isArchive=='t'){
				 $mainLabelUrl = base_url(lang().'/event/eventwithlaunch/deletedItems/');
			}else{
				$mainLabelUrl = base_url(lang().'/event/eventwithlaunch/eventwithlaunchdetail/');
			}
		}
		else {
		 $mainLabelUrl = 'javascript:void(0);';
		}
}else{
	if(@$leftListData[0]['NatureId'] == 2) { 
		if($isArchive=='t'){
			 $mainLabelUrl = base_url(lang().'/event/events/deletedItems/'.$leftListData[0]['compeventid']);
		}else{
			$mainLabelUrl = base_url(lang().'/event/events/eventdetail/'.$leftListData[0]['compeventid']);
		}
		
	}
	else if(@$leftListData[0]['NatureId'] == 3) {
		if($isArchive=='t'){
			 $mainLabelUrl = base_url(lang().'/event/launch/deletedItems/'.$leftListData[0]['compeventid']);
		}else{
			$mainLabelUrl = base_url(lang().'/event/launch/launchdetail/'.$leftListData[0]['compeventid']);
		}
		
	}
	else if(@$leftListData[0]['NatureId'] == 4) { 
		if($isArchive=='t'){
			 $mainLabelUrl = base_url(lang().'/event/eventwithlaunch/deletedItems/'.$leftListData[0]['compeventid']);
		}else{
			$mainLabelUrl = base_url(lang().'/event/eventwithlaunch/eventwithlaunchdetail/'.$leftListData[0]['compeventid']);
		}
		
	}
	else {
	 $mainLabelUrl = 'javascript:void(0);';
	}
}
$leftEventCount = 0;
$pagecounter = 4;					
$pageincrementer = 5;


?>
<div class="row">
	<div class="clear"></div>	
	<div class="cell frm_heading">
		<h2><a href="<?php echo $mainLabelUrl;?>" class="ptr dash_link_hover"><?php echo $eventLabel;?></a></h2>
	</div>  
		<?php if($totalLiRecord>0) { ?>              
	<div class="clear"></div>
			
	<div id="items<?php echo $natureId;?>" class="fl">
		<?php if($totalLiRecord>$pageincrementer){?>
			<div class="slider event_scroll_btn_box " id="slider<?php echo $natureId;?>">		
			<?php		 
			$heightLi = '200px';//if slider then height
		 }
		 else $heightLi = (40*$totalLiRecord).'px'; //$heightLi = '180px';//if no slider then height
		?>			 						
		<div class="viewport ml10 cs_article" style="height:<?php echo $heightLi;?>; width:175px">
			<ul class="overview">
				<li style="height:<?php echo $heightLi;?>; width:175px; float:left">
				<?php 
				
				$test = '';
				$sliderStartFrom = 1;
				
				foreach($leftListData as $countEvent => $leftEvent) {
					 if($leftEvent['NatureId'] == 2) 
					 {
						 $prefix = 'EV';//Event
						 $detailUrl = base_url(lang().'/event/events/eventdetail/'.$leftEvent['compeventid']);
						 if($isArchive=='t'){
							 $detailUrl = base_url(lang().'/event/events/deletedItems/'.$leftEvent['compeventid']);
						 }
					 }
					 else if($leftEvent['NatureId'] == 3) 
					 {			
						 $prefix = 'LE';//Launch Event
						 $detailUrl = base_url(lang().'/event/launch/launchdetail/'.$leftEvent['compeventid']);
						 if($isArchive=='t'){
							  $detailUrl = base_url(lang().'/event/launch/deletedItems/'.$leftEvent['compeventid']);
						 }
					 }
					 else if($leftEvent['NatureId'] == 4) 
					 {
						 $prefix = 'EWL';//Event With Launch
						 $detailUrl = base_url(lang().'/event/eventwithlaunch/eventwithlaunchdetail/'.$leftEvent['compeventid']);
						 if($isArchive=='t'){
							   $detailUrl = base_url(lang().'/event/eventwithlaunch/deletedItems/'.$leftEvent['compeventid']);
						 }
					 }
					 else 
					 {
					   $detailUrl = 'javascript:void(0);';
					 }
					//echo $detailUrl;
						$Title = $leftEvent['Title'];
					
					if($prefix.$selectedEventId == $prefix.$leftEvent['compeventid'])
					{
						$liColor = 'active';
						$sliderStartFrom=ceil(($countEvent+1)/5);
					}
					else
					{
						$liColor = ''; 
					}			
					
					$leftEventCount++;
					
				if(isset($detailUrl) && $detailUrl!='')
				{
				?>				
					<div class="row <?php echo $liColor;?>">
					<a href="<?php echo $detailUrl;?>" class="<?php echo $liColor;?>" ><?php echo getSubString($Title, 18);?></a>
					</div>				
					<?php
				}
					
				if(($leftEventCount>$pagecounter) && ($leftEventCount < $totalLiRecord) &&($totalLiRecord>$pageincrementer)){
					$pagecounter= $pagecounter+$pageincrementer;
					echo '</li><li style="height:'.$heightLi,'; width:175px; float:left">'; 
				}
				else if($leftEventCount==$totalLiRecord) echo '</li>'; 
			}//End Foreach
?>
</ul>
<div class="clear"></div>
</div><!-- End viewport-->
<div class="clear"></div>
<?php if($totalLiRecord>$pageincrementer) { ?>
<div class="position_relative">
	<div class="z_index_2 position_relative">
         <a class="buttons next" href="#"></a><a class="buttons prev mr15 disable" href="#"></a>
    </div>
	<!--FAKEDIV-->
	<div class="fakebtn z_index_1">
		<span class="buttons next"></span><span class="buttons prev mr15"></span>
	</div>
        </div>	
		    <div class="clear"></div>
		</div><!-- End slider -->
<?php } ?>	
		<div class="clear"></div>
	</div><!-- End item -->


<div class="clear"></div>  

<?php }
else{
				echo '<div class="seprator_34 row"></div>';
			}?>
</div><!-- End Row -->
<?php if($totalLiRecord>0) { ?>  
<script type="text/javascript">
/* tab function */
	$(document).ready(function(){
		$('#slider<?php echo $natureId;?>').tinycarousel({ axis: 'x', display: 1, start:<?php echo $sliderStartFrom; ?>});		
	});
</script>
<?php } ?>
