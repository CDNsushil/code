<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
$formAttributes = array(
    'name'=>'publiciseBlogForm',
    'id'=>'publiciseBlogForm',
);

$blogIdField = array(
	'name'	=> 'blogId', 
	'value'	=>  (isset($blogId))?$blogId:0,
	'id'	=> 'blogId',
	'type'	=> 'hidden'
);

// set base url
$baseUrl = base_url(lang().'/blog/');
?>
<div class="content TabbedPanelsContent width635 m_auto">
	<div class="c_1">
		<h3><?php echo $this->lang->line('publishYourBlog');?></h3>
		<h4><?php echo $this->lang->line('publishItToOnline');?></h4>
		<div class="sap_20"></div>
		<div class="butn ml0 pad_2 b_f7f7f7 bdr_b4b4b4 lineH18 fl">
			<span class="defaultP table_cell fs14">
				<label class="mr15">
					<input type="radio" name="publishblog" value="1" checked /><?php echo $this->lang->line('now');?>
				</label>
				<label>
					<input type="radio" name="publishblog" value="0" /><?php echo $this->lang->line('later');?>
				</label>
			</span>
		</div>
		<div class="fr btn_wrap display_block font_weight">
			<a href="<?php echo $baseUrl.'/blogcoverimage';?>"><button class=" bg_ededed bdr_b1b1b1 mr5">Cancel</button></a>
			<a onclick="window.history.back();"><button class=" back bdr_b1b1b1 mr5" >Back </button></a>
			<a onclick="managePublisice()"><button class="b_F1592A bdr_F1592A"> Next </button></a>
		</div>	
		<div class="sap_25"></div>
	</div>
</div>
<script type="text/javascript">
	function managePublisice() {
		var publishblog = $("input[name=publishblog]:checked").val();
		if( publishblog == 0 ) {
			window.location.href = '<?php echo base_url(lang().'/blogs/index');?>'; 
		} else {
			window.location.href = '<?php echo $baseUrl.'/previewnpublishblog';?>'; 
		}
	}
</script>
