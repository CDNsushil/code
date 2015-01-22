<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
	
<div class="fl width_776 ml5 mr19">	
	
	<?php
	if(!$hideHeading){
		?>
		<div class="height27">
			<?php
			if(!isLoginUser()){?>
				<div class="fl ml34 mt-8">
					<a class="joinbtn_new black_link_hover" href="<?php echo base_url(lang().'/package/packagestageone');  ?>" onmouseup="mouseup_joinbtn_new(this)" onmousedown="mousedown_joinbtn_new(this)" href="#">Join</a><span class=""></span>
				</div>
				<?php
			}?>
			<div class="font_museoSlab font_size30 bdrB_f15921 text_alignR <?php echo $clr_white;?> mt14 pb1">Membership Information </div>
			<div class="clear"></div>
		</div>
		<?php
	}
	?>
	<div class="clear"></div>
	<div class="seprator_8"></div>
	<!--<div class="bg_f9f9f9">-->
	<div>
	<div class="position_relative bg_white min_h685">
	<div class="cell memimgshedow_wp strip_absolute_right left_201 overflow_h">
		<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody><tr>
		<td height="9"><img src="<?php echo base_url();?>images/dashsimgleftshedow.png"></td>
		</tr>
		<tr>
		<td class="dashimgshedow">&nbsp;</td>
		</tr>
		<tr>
		<td height="9"><img src="<?php echo base_url();?>images/dashsimgleftshedow.png"></td>
		</tr>
		</tbody></table>					
	</div>
	<div class="clear"></div>
	<?php 
	$this->load->view('package/package_left_menu',array('memberbox_left_shedow'=>$memberbox_left_shedow));
	
	$this->load->view('package/package_free');
	$this->load->view('package/package_trail_opening');
	$this->load->view('package/package_sell');
	?>
	
	<div class="clear"></div>
	</div>
	
	<div class="memberBshedow"></div>
	</div>

	<div class=" seprator_13"></div>
	
	<?php 
	$this->load->view('package/package_free_slider');
	$this->load->view('package/package_trail_opening_slider');
	$this->load->view('package/package_sell_slider');
	?>
	
	
</div>

<script type="text/javascript">
	function membershipInfo(obj,menuClass,currentDiv,eachDiv){
		var nowClass;
		if(menuClass && menuClass != ''){
			$(menuClass).each(function(index){
				nowClass = $(this).attr('class').replace('dashbgimg_gradient_orange', 'dashbgimg_gradient');
				$(this).attr('class',nowClass);
			});
		}
		nowClass = $(obj).attr('class').replace('dashbgimg_gradient','dashbgimg_gradient_orange');
		$(obj).attr('class',nowClass);
		if(eachDiv && eachDiv != ''){
			$(eachDiv).each(function(index){
				$(this).hide();
			});
		}
		if(currentDiv && currentDiv != ''){
			$(currentDiv).each(function(index){
				$(this).show();
			});
		}
		if(currentDiv=='.msiFree'){
			 $(".min_h685").css('minHeight',  685);
		}else{
			 $(".min_h685").css('minHeight',  623);
		}
	}
</script>

