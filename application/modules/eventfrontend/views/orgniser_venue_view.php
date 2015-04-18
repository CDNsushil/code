<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
		//echo '<pre />';print_r($venueOrgniserDetails);
		$venueOrgniser=$this->load->view('orgniser_venue_details',$venueOrgniserDetails,true);
		$id=$venueOrgniserDetails['id'];
		$venueOrgniserClass=isset($venueOrgniserDetails['venueOrgniserClass'])?$venueOrgniserDetails['venueOrgniserClass']:'width_98 clr_ccc pt2 pl6 pb5 eventL_actionseprator';
?>
<script>var venueOrgniserDetails<?php echo $id;?>=<?php echo json_encode($venueOrgniser);?>;</script>
 <?php
  //echo '$section:'.$section;
	if(isset($section) && $section=='eventSession'){ 
		if(@$venueOrgniserDetails['OrgName']!=''){ ?>
			<div class="cell mt12 ml10"><a class="Dgrey_btn black_link_hover" onmouseup="mouseup_Dgrey_btn(this)" onmousedown="mousedown_Dgrey_btn(this)" onclick="venueOrgniserDetails(venueOrgniserDetails<?php echo $id;?>,'#orgniserTab<?php echo $id;?>','#orgniserDetails<?php echo $id;?>')"><?php echo $this->lang->line('orgInfo');?></a></div>
		<?php }	if(@$venueOrgniserDetails['venueaddress']!=''){ ?>
			<div class="ml10 cell mt12"><a class="Dgrey_btn black_link_hover" onmouseup="mouseup_Dgrey_btn(this)" onmousedown="mousedown_Dgrey_btn(this)" onclick="venueOrgniserDetails(venueOrgniserDetails<?php echo $id;?>,'#venueTab<?php echo $id;?>','#venueDetails<?php echo $id;?>')"><?php echo $this->lang->line('addLocation');?></a> </div>
		<?php
		}
		}else{ ?>
		<ul class="<?php echo $venueOrgniserClass;?>">
		<?php if(@$venueOrgniserDetails['venueName']!=''){ ?>
		<li class="ptr pb3 hoverOrange" onclick="venueOrgniserDetails(venueOrgniserDetails<?php echo $id;?>,'#venueTab<?php echo $id;?>','#venueDetails<?php echo $id;?>')"><?php echo $this->lang->line('addLocation');?></li>
		<?php }if(@$venueOrgniserDetails['OrgName']!=''){ ?>
		<li class="ptr hoverOrange" onclick="venueOrgniserDetails(venueOrgniserDetails<?php echo $id;?>,'#orgniserTab<?php echo $id;?>','#orgniserDetails<?php echo $id;?>')"><?php echo $this->lang->line('orgInfo');?></li>
		<?php } ?>
	  </ul>
	<?php
	}
 ?>
	  
