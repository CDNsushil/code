<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="position_relative ml9 mr9 container_tipshelp pt10 pb6">
		<table cellspacing="0" cellpadding="0" class="pl1 pr1">
	<tr>
		
		<td  style="vertical-align: top;">
         		
            		<div class="shadow_wp strip_absolute_right right_436 panel">
						<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody><tr>
								<td height="271">	<img src="<?php echo base_url().'images/shadow-top.png';?>"></td>
							</tr>
							<tr>
								<td class="shadow_mid">&nbsp;</td>
							</tr>
							<tr>
								<td height="271"><img src="<?php echo base_url().'images/shadow-bottom.png';?>"></td>
							</tr>
						</tbody></table>
	
					</div>
					</td>

	<td class="bg_white width_474 pl28 pr28 panel" valign="top">
        <?php if(isset($description) && !empty($description)){ 
			$site_base_url = site_url('');
			$searchArray = array("{site_base_url}");
			$replaceArray = array($site_base_url);	
		?>
   
		<div class="fl">
            <div class="seprator_29"></div>		
			<?php 
			foreach($description as $f)
			{ ?>
			<div class="font_size24 clr_f1592a font_museoSlab tips_shedow">
			<?php
			if(isset($f['title']) && !empty($f['title'])){
				echo $f['title'];
			 }?>
			</div>
			<div class="clear"></div>
			<div class="seprator_25"></div>
			<div class="font_opensansSBold font_size18 clr_733737 bdrt_e5e5e5 bdrb_e5e5e5 pt2 pb4">
				<?php
				if(isset($f['subtitle']) && !empty($f['subtitle'])){
					echo $f['subtitle'];
				}
				?>
			</div>
			<div class="clear"></div>
			<div class="seprator_20"></div>
			<div class="font_opensans tips_desc font_size13 clr_222 NIC">
				<?php 
				if(isset($f['description']) && !empty($f['description'])){
					$tips_description=str_replace($searchArray, $replaceArray, $f['description']);
					echo changeToUrl($tips_description);
				}
				?>
			</div>
			<div class="seprator_15"></div>
			<?php }?>
		</div>
	<?php }else{ 
		$site_base_url = site_url('');
		$searchArray = array("{site_base_url}");
		$replaceArray = array($site_base_url);	
		?>
	<!--Default display left side content-->
	
	<div class="fl">
	<div class="seprator_29"></div><?php 
		foreach($topDescription as $f)
		{ 
		?>
		<div class="font_size24 clr_f1592a font_museoSlab tips_shedow">
		<?php
		if(isset($f['title']) && !empty($f['title'])){
			echo $f['title'];
		}?>
		</div>
		<div class="clear"></div>
		<div class="seprator_25"></div>
		<div class="font_opensansSBold font_size18 clr_733737 bdrt_e5e5e5 bdrb_e5e5e5 pt2 pb4">
		<?php
		if(isset($f['subtitle']) && !empty($f['subtitle'])){
			echo $f['subtitle'];
		}
		?>
		</div>
		<div class="clear"></div>
		<div class="seprator_22"></div>
  		<div class="font_opensans tips_desc font_size13 clr_222 NIC">
			<?php 
			if(isset($f['description']) && !empty($f['description'])){
				echo $tips_description=str_replace($searchArray, $replaceArray, $f['description']);
				echo changeToUrl($tips_description);
			}
			?>
        </div>
        <div class="seprator_15"></div>
		<?php
		}?>
	</div>
	
	<?php } ?> 
            
	</td>
     
      <td class="bg_373737 pl18 pr12 width_422 panel" valign="top">
            <div class="fl width_100_per">
            <div class="seprator_13"></div>
            <div class="text_alignR font_size18 pr10 ml5 pb4"><a href="<?php echo site_url('help');?>" class="clr_white font_opensans dash_link_hover"><?php echo $this->lang->line('tipsForum');?><span class="aerrow_forum"></span></a>
            <div class="bdrB_6e6e6e mt4 width_385"></div>
            </div>
           <div class="seprator_24"></div>
              
              <div class="helptipslist_box">
              <div class="font_opensans font_size18 clr_white tipshelp_btmline ml8"><?php echo $this->lang->line('tips');?></div>
              <div class="seprator_22"></div>
	<ul>
		<?php foreach($tips as $d){ ?>
		<li>
			<div class="row mt10">
			<a href="<?php echo site_url('tips/front_tips/'.$d['id']);?>" class="font_museoSlab"><div class="cell font_museoSlab"> <?php echo $d['title'] ?>:</div>
			<span class="cell ml10 font_museoSlab"><?php echo $d['subtitle'] ?></span></a></div>
			<div class="clear mb8"></div>
		</li>			
		<?php } ?>
	</ul>
	</div>
     
        
    <div class="seprator_20"></div>
	<div class="clear"></div>
	</div>
	</td>
            
	<div class="clear"></div>
	</tr>
	</table>
	</div>
       
  
