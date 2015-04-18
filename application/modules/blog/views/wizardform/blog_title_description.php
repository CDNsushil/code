<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'titleNDescForm',
    'id'=>'titleNDescForm',
);

$blogTitleValue = set_value('blogTitle')?set_value('blogTitle'):$blodData->blogTitle;
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

$blogOneLineDescValue = set_value('blogOneLineDesc')?set_value('blogOneLineDesc'):$blodData->blogOneLineDesc;
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


$blogDescValue = set_value('blogDesc')?set_value('blogDesc'):$blodData->blogDesc;
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


$blogTagWordsValue = set_value('blogTagWords')?set_value('blogTagWords'):$blodData->blogTagWords;
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

$blodIdField = array(
        'name'	=> 'blogId', 
        'value'	=>  (isset($blodData))?$blodData->blogId:0,
        'id'	=> 'blogId',
        'type'	=> 'hidden'
);
    
// set base url
$baseUrl = base_url(lang().'/blog/');
?>
 

<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/setdevelopmentdetails/',$formAttributes); 
    ?>
		<div class="c_1 clearb">
			<ul class="form_img mt25 mb25">
				<li>
					<h4 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('blogFormTitle')?> </h4>
					 <span class="pl10 fs13 fshel_midum">1 - 15 words</span> 
					 <span class="red fr fs13 fshel_midum"><span id="blogTitleBox"><?php echo str_word_count($blogTitleValue);?></span>  <span>words</span> </span></label>
					<?php echo form_input($blogTitleInput); ?>
                </li>
                
                <li>
                    <h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('blogFormIntroduction')?> </h4>
                    <span class="pl10 fs13 fshel_midum">3 - 50 words</span> 
                    <span class="red fr pr10 fs13 fshel_midum"><span id="blogIntroBox"><?php echo str_word_count($blogOneLineDescValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($blogOneLineDescInput); ?>
                </li>
                
				<li>
					<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('blogFormMoreAbout')?> </h4>
                    <span class="pl10 fs13 fshel_midum">0 - 200 words</span> 
                    <span class="red fr pr10 fs13 fshel_midum"><span id="blogAboutBox"><?php echo str_word_count($blogDescValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($blogDescInput); ?>
                </li>
              
				<li>
					<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('blogFormTag')?> </h4>
                    <span class="pl10 fs13 fshel_midum">3 - 25 words</span> 
                    <span class="red fr pr10 fs13 fshel_midum"><span id="blogWordBox"><?php echo str_word_count($blogTagWordsValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($blogTagWordsInput); ?>
				</li>
           </ul>
			<ul>
				<li class="icon_2">
					Tag Words do not appear on the site. They help search engines find your work.                                               
				</li>
			</ul>
        </div>
    <?php 
		echo form_input($blodIdField); 
    echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back page
    $data['backPage'] = '/blog/blogcoverimage';
    // set next form name
    $data['formName'] = 'titleNDescForm';
    
    $this->load->view('wizardform/blog_buttons',$data);
    ?>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
        $("#titleNDescForm").validate({
            submitHandler: function() {
                var fromData=$("#titleNDescForm").serialize();
                $.post('<?php echo $baseUrl.'/setblogdescdetails';?>',fromData, function(data) {
                    if(data) {
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
</script>
