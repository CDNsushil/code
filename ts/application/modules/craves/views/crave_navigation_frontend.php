<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$myCravesHL=$cravingMeHL='font_opensans';
	$myCravesbbo=$cravingMebbo='orange_underline_hover';
	if($myCraves == $activeheading){
		$myCravesHL='font_opensansSBold';
		$myCravesbbo='bbo';
		
	}elseif($myCraves != $cravingMe){
		$cravingMeHL='font_opensansSBold';
		$cravingMebbo='bbo';
	}
	
	$isShowSeprater = false;
?>
<div class="fl mt5 ml10 width368px">
	 <div class="row">
		<?php
		if(isset($myCravesCount) &&  is_numeric($myCravesCount) && $myCravesCount > 0){ 	
			$isShowSeprater=true;
		?>
			<div class="cell <?php echo $myCravesbbo;?>">
				<a class="orange f20  <?php echo $myCravesHL;?>" href="<?php echo base_url(lang().'/craves/craveslist/'.$userId);?>"><?php echo $myCraves;?></a>
			</div>
			
			<?php
		}
		if((isset($myCravesCount) &&  is_numeric($myCravesCount) && $myCravesCount > 0) && (isset($cravingMeCount) &&  is_numeric($cravingMeCount) && $cravingMeCount > 0)){
			echo '<div class="cell pl5 pr5  orange f22 font_opensans">|</div>';
		}
		if(isset($cravingMeCount) &&  is_numeric($cravingMeCount) && $cravingMeCount > 0){
		$isShowSeprater=true;	
		?>
			<div class="cell <?php echo $cravingMebbo;?>">
				<a class="orange f20 <?php echo $cravingMeHL;?>" href="<?php echo base_url(lang().'/craves/cravingmefrontend/'.$userId);?>" ><?php echo $cravingMe;?></a>
			</div>
			<?php
		}
		
		if(getMyPlaylistCount($userId) && $isShowSeprater){
			echo '<div class="cell pl5 pr5  orange f22 font_opensans">|</div>';
		}
		
		if(getMyPlaylistCount($userId)){ ?>	
			
			<div class="cell orange_underline_hover">
				<a class="orange f20  font_opensans" href="<?php echo base_url(lang().'/mediafrontend/myplaylist/'.$userId);?>" ><?php echo $this->lang->line('myplaylist');?></a>
			</div>
		
		<?php 	
		}	
		
		
		?>
	</div>
</div>


