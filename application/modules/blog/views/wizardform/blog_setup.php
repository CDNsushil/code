<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'blogSetupForm',
    'id'=>'blogSetupForm',
);

$blogTitleValue = set_value('blogTitle')?set_value('blogTitle'):$blogData->blogTitle;
$blogTitleValue = htmlentities($blogTitleValue);

$blogTitleInput = array(
    'name'        =>  'blogTitle',
    'id'          =>  'blogTitle',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
    'value'       =>  html_entity_decode($blogTitleValue),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'blogTitleBox')",
    'placeholder' =>  "Blog Title",
    'onBlur'      =>  "placeHoderHideShow(this,'Blog Title','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Blog Title','hide')"
);

$blogOneLineDescValue = set_value('blogOneLineDesc')?set_value('blogOneLineDesc'):$blogData->blogOneLineDesc;
$blogOneLineDescValue = htmlentities($blogOneLineDescValue);

$blogOneLineDescInput = array(
    'name'        =>  'blogOneLineDesc',
    'id'          =>  'blogOneLineDesc',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($blogOneLineDescValue),
    'wordlength'  =>  "3,50",
    'onkeyup'     =>  "checkWordLen(this,50,'blogIntroBox')",
    'placeholder' =>  "Blog Introduction",
    'onBlur'      =>  "placeHoderHideShow(this,'Blog Introduction','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Blog Introduction','hide')"
);


$blogDescValue = set_value('blogDesc')?set_value('blogDesc'):$blogData->blogDesc;
$blogDescValue = htmlentities($blogDescValue);

$blogDescInput = array(
    'name'        =>  'blogDesc',
    'id'          =>  'blogDesc',
    'class'       =>  'font_wN width_615 height_215 bdr_adadad mt13',
    'value'       =>  html_entity_decode($blogDescValue),
    'wordlength'  =>  "0,200",
    'onkeyup'     =>  "checkWordLen(this,50,'blogAboutBox')",
    'placeholder' =>  "More About your Blog",
    'onBlur'      =>  "placeHoderHideShow(this,'More About your Blog','show')",
    'onClick'     =>  "placeHoderHideShow(this,'More About your Blog','hide')"
);


$blogTagWordsValue = set_value('blogTagWords')?set_value('blogTagWords'):$blogData->blogTagWords;
$blogTagWordsValue = htmlentities($blogTagWordsValue);

$blogTagWordsInput = array(
    'name'        =>  'blogTagWords',
    'id'          =>  'blogTagWords',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    'value'       =>  html_entity_decode($blogTagWordsValue),
    'wordlength'  =>  "3,25",
    'onkeyup'     =>  "checkWordLen(this,25,'blogWordBox')",
    'placeholder' =>  "Tag Words",
    'onBlur'      =>  "placeHoderHideShow(this,'Tag Words','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Tag Words','hide')"
);

$blogToTwitter = array(
	'name'        => 'blogToTwitter',
	'id'          => 'blogToTwitter',
	'value'       => 'accept',
	'checked'     => $blogData->blogToTwitter =='t'?TRUE:FALSE,
	'class'       => 'formTip',
	'title'       => $this->lang->line('twitterblog')
);

$blogTwitterLink = array(
	'name'        => 'blogTwitterLink',
	'id'          => 'blogTwitterLink',
	'size'		  =>  35,
	'class'       => 'bdr_adadad clr_444 mr20 width_400',
	'value'       => $blogData->blogTwitterLink,
	'placeholder' => "URL e.g .https://twitter.com/Toadsquare",
    'onBlur'      => "placeHoderHideShow(this,'URL e.g .https://twitter.com/Toadsquare','show')",
    'onClick'     => "placeHoderHideShow(this,'URL e.g .https://twitter.com/Toadsquare','hide')"
);
	
$gototwitterurl = '';
//If the twitter link is given then show the view button else not
if(isset($blogData->blogTwitterLink) && $blogData->blogTwitterLink!='') {
	if (preg_match(('/^(http|https|www)/'),$blogData->blogTwitterLink)) 
		$gototwitterurl = $blogData->blogTwitterLink;
	else 
		$gototwitterurl = 'http://twitter.com/'.$blogData->blogTwitterLink;
	
	$showTwitButtonClass = ''; 
} else { 
	$showTwitButtonClass='dn';
}

$blogIdField = array(
        'name'	=> 'blogId', 
        'value'	=>  (isset($blogData))?$blogData->blogId:0,
        'id'	=> 'blogId',
        'type'	=> 'hidden'
);
    
// set base url
$baseUrl = base_url(lang().'/blog/');

$checkYes = '';
$checkNo = 'checked';

if($blogData->blogToDonate == 't') {
	$checkYes = 'checked';
	$checkNo = '';
}
?>

<div class="content TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/setblogsetup/',$formAttributes); 
    ?>
		<div class="c_1">
			<div class="clearb fl">
				<h3>Add your Twitter Feed</h3>
				<div class="sap_15"></div>
				<span class="fl defaultP pt4" >
					<span class="pt4 fl"><?php echo form_checkbox($blogToTwitter); ?></span>
					<?php echo form_input($blogTwitterLink);?>
				</span>
				<span class="fr <?php echo $showTwitButtonClass;?>">
					<a href="javascript://void(0);" onclick="gototwit();">
						<input type="button" value="Check your link" class=" fr width150 height40 bdr_a0a0a0 fshel_bold orangeHover">
					</a>
				</span>
			</div>
			
			<div class="clearbox">
				<?php echo Modules::run("blog/addblogcategory",$blogData->blogId);?>
			</div>
			
			<div class="clearbox">
				<h3>Would you like to ask members to make a donation
				if they like your work?
				</h3>
				<div class=" mt28  butn ml0 pad_2 b_f7f7f7 fs16 bdr_b4b4b4 lineH18 fl">
					<span class="defaultP table_cell fs14">
						<label class="mr10">
							<input type="radio" name="blogToDonate" value="f" <?php echo $checkNo;?> /> No
						</label>
						<label>
							<input type="radio" name="blogToDonate" value="t" <?php echo $checkYes;?> /> Yes
						</label>
					</span>
				</div>
				<ul class="org_list">
					<li class="icon_1 clr_444">
						This is not a charitable donation. It is a ‘thank you’ from members who like your work, so it’s treated as a sale on Toadsquare. You will need a <a href="">PayPal</a> account to recieve a donation.  You also need to setup your Shopping Cart to recieve payments. To do this select <a href="">Seller Settings</a> from
						<b>Your Toadsquare > Your Global Settings</b>.
					</li>
					<li class=" clr_444">
						A Toadsquare Service Fee; the greater of EUR 0.40 / USD 0.50 or 15 percent and Consumption Tax (VAT, GST, Sales Tax etc.), if applicable, 
						will be deducted from your donation. The Service Fee and Donation are non-refundable. 
					</li>
				</ul>
			</div>
		</div>
		<?php 
		echo form_input($blogIdField); 
    echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back page
    $data['backPage'] = '/blog/bloginformation';
    // set next form name
    $data['formName'] = 'blogSetupForm';
    
    $this->load->view('wizardform/blog_buttons',$data);
    ?>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
        $("#blogSetupForm").validate({
            submitHandler: function() {
                var fromData=$("#blogSetupForm").serialize();
                $.post('<?php echo $baseUrl.'/setblogsetup';?>',fromData, function(data) {
                    if(data) {
                       window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
    
    function gototwit() {
		window.open(
			'<?php echo $gototwitterurl?>',
			'_blank' // <- This is what makes it open in a new window.
		);
	}
</script>
