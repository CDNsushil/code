<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// set base url
$baseUrl = base_url(lang());
$blogPublishBtn = $this->lang->line('pubPost');

if($postData->isPublished == 't') {
	$blogPublishBtn = $this->lang->line('unpubPost');
}
?>
<div class="content TabbedPanelsContent width635 m_auto">
	<div class="c_1">
		<h3> <?php echo $this->lang->line('prevNPubYourPost');?> </h3>
		<h4 class="font_bold fs16"><?php echo $this->lang->line('prevNPubYourPost1');?></h4>
		<div class="clearb finsh_button fl">
			<div class="sap_20"></div>                
			<a href="<?php echo $baseUrl.'/blog/previewyourpost/'.$postId;?>" target="_blank">
				<button class="red bdr_a0a0a0 ml40" type="button" ><?php echo $this->lang->line('prevPost');?></button>
			</a>
			<a href="<?php echo $baseUrl.'/blog/publishpost/'.$postId;?>">
				<button class="red bdr_a0a0a0 ml15" type="button"><?php echo $blogPublishBtn;?></button>
			</a>
		</div>
		<ul class="org_list">
			<li class="icon_2">
				<?php echo $this->lang->line('prevNPubYourPost2');?>
				<span class="clearb"><?php echo $this->lang->line('prevNPubYourPost3');?></span>                                              
			</li>
			<li>
				<?php echo $this->lang->line('prevNPubYourPost4');?>	
			</li>
		</ul>
		<div class="fr btn_wrap display_block font_weight">
			<a href="<?php echo $baseUrl.'/blog/blogcoverimage';?>"><button class=" bg_ededed bdr_b1b1b1 mr5">Cancel</button></a>
			<a onclick="window.history.back();"><button class=" back bdr_b1b1b1 mr5" >Back </button></a>
			<a href="<?php echo base_url(lang().'/blogs/index');?>"><button class="b_F1592A bdr_F1592A"> Next </button></a>
		</div>	
		<div class="sap_25"></div>
	</div>
</div>
