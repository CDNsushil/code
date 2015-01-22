<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="pall3">
	<div class="bg_f3f3f3 pall8">
		<div class="enterprise_boxcon bg_white pt25 pb50 pr50 pl115 shedow_prnews">
		<div class="seprator_25"></div>
			<div class="row">
				<div class="prnewsmenu font_opensansLight">
				<ul>
					<li class="firsthild"><a href="<?php echo base_url(lang().'/pressRelease/index');?>" > Press Releases </a> </li>
					<li class="width_120"><a href="javascript:void(0)" class="active">In The News </a> </li>
					<li class="width192"><a href="<?php echo base_url(lang().'/news/launch_list');?>">Toadsquare Launch </a></li>
					<li class="listchild"><a href="<?php echo base_url(lang().'/news/information_list');?>">Toadsquare Information </a></li>
				</ul>
				</div>
			</div>
			
			<div class="clear"></div>
			<div class="seprator_30"></div>
			<div class="clear"></div>
			<?php
			 $sk=0;
			if($press_list)foreach($press_list as $press_listing){ 
				
				?>
				<div class="fl width_729 newsright_anchor">
						<div class="row">
							<div class="font_opensansLight font_size24 clr_58595b bdr_Bgrey lineH40"><?php echo date("F Y",strtotime($press_listing['monthName']));?></div>
						</div>
				
				<?php
				$nextDate="";
				if(isset($press_listing['get_num_rows']) && $press_listing['get_num_rows'] > 0)
				{
					foreach($press_listing['get_result'] as $k=>$press_lists){ 
						?>
						<div class="seprator_15"></div>
						<div class="row font_opensansSBold font_size13">
							<div class="fl width_152"><?php
							if($nextDate != $press_lists['date'])
							{
								echo date("d F Y",strtotime($press_lists['date']));
							}else
							{
								echo "&nbsp;";
							}
							?></div>
							<div class="fl width_570"> 
							<a href="<?php echo base_url('news/details/'.$press_lists['id']);?>"><?php echo $press_lists['title'];?></a>
							<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					<?php
					$nextDate = $press_lists['date'];
					 }	
				}
				?>
				
				<div class="clear"></div> 
					</div>
			<div class="clear"></div> 
			<div class="seprator_15"></div>
			<?php 	
				
			}	?>
			<div class="clear"></div> 
		</div> <!-- enterprise_boxcon -->
	</div>
</div>
<!--<div class="seprator120"></div>-->

    

<!--End cmslist of title -->
