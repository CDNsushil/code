<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'blogInfoForm',
    'id'=>'blogInfoForm',
);

$blodIdField = array(
        'name'	=> 'blogId', 
        'value'	=>  (isset($blodData))?$blodData->blogId:0,
        'id'	=> 'blogId',
        'type'	=> 'hidden'
);
    
// set base url
$baseUrl = base_url(lang().'/blog/');
?>

<div class="content TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/setblogInformation/',$formAttributes); ?>
		<div class="c_1">
			<h3>Information about your Blog</h3>
			<div class="pannel7 Image_Info blog_info "> 
				<!--========================== Step 3  innertab==============================-->
				<ul id="tabs_nav" class=" mt60 width226 fl bdr_right_666 fshel_midum">
					<li><a href="#" name="#tab1"  id="current">Main Focus*</a></li>
					<li><a href="#" name="#tab2">Language*</a></li>
					<li><a href="#" name="#tab3"><?php echo $this->lang->line('selectRating')?>*</a></li>
				</ul>
				<!--=========== Step 3  inner tab content ========-->
				<div id="content_tabs" class="fl pl30 width_361 mt60">
					<div id="tab1">
						<ul class="billing_form width169 mt2 pl10 fl">
							<li class="select">
								<?php 
								$blogIndustry = set_value('blogIndustry')?set_value('blogIndustry'):$blodData->blogIndustry;
								if( ! $blogIndustry > 0) {
									$blogIndustry = '';
								}
								//$industryList = getIndustryList();
								echo form_dropdown('blogIndustry', $workIndustryList, $blogIndustry,'id="industryId" class="required" ');
                                    ?>
							</li>
						</ul>
					</div>
					<div id="tab2">
						<ul class="billing_form width169 mt2 pl10 fl">
							<li class="select">
								<?php 
								$blogLanguage=set_value('blogLanguage')?set_value('blogLanguage'): $blodData->blogLanguage;
								$blogLanguageList = getlanguageList();
								echo form_dropdown('blogLanguage', $blogLanguageList, $blogLanguage,'id="blogLanguage" class=" main_SELECT required"');
								?> 
							</li>
						</ul>
					</div>
					<div id="tab3">
						<ul class="billing_form width169 mt2 pl10 fl">
							<li class="select">
								<?php
								$rating=set_value('rating')?set_value('rating'): $blodData->rating;					
								$ratingList = getRatingList();
								echo form_dropdown('rating', $ratingList,$rating ,'id="rating" class="main_SELECT width100 required" ');?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<?php 
		echo form_input($blodIdField); 
    echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back page
    $data['backPage'] = '/blog/blogtitlendescription';
    // set next form name
    $data['formName'] = 'blogInfoForm';
    
    $this->load->view('wizardform/blog_buttons',$data);
    ?>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
        $("#blogInfoForm").validate({
            submitHandler: function() {
				var blogIndustry  =  $('#blogIndustry').val();
				var rating        =  $('#rating').val();
				var blogLanguage  =  $('#blogLanguage').val();
				
                var fromData=$("#blogInfoForm").serialize();
                if(blogIndustry != '' && rating != 0 && blogLanguage != '') {
					$.post('<?php echo $baseUrl.'/setblogInformation';?>',fromData, function(data) {
						if(data) {
							window.location.href = data.nextStep; 
						}
					}, "json");
				} else {
					alert('Please fill required fields');
					return false;
				}
            }
        });
    });
</script>
