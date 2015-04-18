<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'titleNDescForm',
    'id'=>'titleNDescForm',
);

$postTitleValue = set_value('postTitle')?set_value('postTitle'):$postData->postTitle;
$postTitleValue = htmlentities($postTitleValue);

$postTitleInput = array(
    'name'        =>  'postTitle',
    'id'          =>  'postTitle',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
    'value'       =>  html_entity_decode($postTitleValue),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'blogTitleBox')",
    'placeholder' =>  "Post Title",
    'onBlur'      =>  "placeHoderHideShow(this,'Post Title','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Post Title','hide')"
);

$postOneLineDescValue = set_value('postOneLineDesc')?set_value('postOneLineDesc'):$postData->postOneLineDesc;
$postOneLineDescValue = htmlentities($postOneLineDescValue);

$postOneLineDescInput = array(
    'name'        =>  'postOneLineDesc',
    'id'          =>  'postOneLineDesc',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($postOneLineDescValue),
    'wordlength'  =>  "3,50",
    'onkeyup'     =>  "checkWordLen(this,50,'blogIntroBox')",
    'placeholder' =>  "Post Introduction",
    'onBlur'      =>  "placeHoderHideShow(this,'Post Introduction','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Post Introduction','hide')"
);


$postTagWordsValue = set_value('postTagWords')?set_value('postTagWords'):$postData->postTagWords;
$postTagWordsValue = htmlentities($postTagWordsValue);

$postTagWordsInput = array(
    'name'        =>  'postTagWords',
    'id'          =>  'postTagWords',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    'value'       =>  html_entity_decode($postTagWordsValue),
    'wordlength'  =>  "3,25",
    'onkeyup'     =>  "checkWordLen(this,25,'blogWordBox')",
    'placeholder' =>  "Tag Words",
    'onBlur'      =>  "placeHoderHideShow(this,'Tag Words','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Tag Words','hide')"
);

$postId = (isset($postData->postId)) ? $postData->postId : 0;
$postIdField = array(
        'name'	=> 'postId', 
        'value'	=>  $postId,
        'id'	=> 'postId',
        'type'	=> 'hidden'
    );

$blogIdField = array(
	'name'	=> 'blogId', 
	'value'	=>  (isset($blogId))?$blogId:0,
	'id'	=> 'blogId',
	'type'	=> 'hidden'
);

$blogUserIdField = array(
	'name'	=> 'blogUserId', 
	'value'	=>  (isset($blogUserId))?$blogUserId:0,
	'id'	=> 'blogId',
	'type'	=> 'hidden'
);

$parentPostIdField = array(
	'name'	=> 'parentPostId',
	'value'	=> (isset($parentPostId))?$parentPostId:0,
	'id'	=> 'parentPostId',
	'type'	=> 'hidden'
);    
   
// set base url
$baseUrl = base_url(lang().'/blogshowcase/');

?>
 

<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/setpostdescdetails/',$formAttributes); 
    ?>
		<div class="c_1 clearb">
			<ul class="form_img mt25 mb25">
				<li>
					<h4 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('postFormTitle')?> </h4>
					 <span class="pl10 fs13 fshel_midum">1 - 15 words</span> 
					 <span class="red fr fs13 fshel_midum"><span id="blogTitleBox"><?php echo str_word_count($postTitleValue);?></span>  <span>words</span> </span></label>
					<?php echo form_input($postTitleInput); ?>
                </li>
                
                <li>
                    <h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('postFormIntroduction')?> </h4>
                    <span class="pl10 fs13 fshel_midum">3 - 50 words</span> 
                    <span class="red fr pr10 fs13 fshel_midum"><span id="blogIntroBox"><?php echo str_word_count($postOneLineDescValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($postOneLineDescInput); ?>
                </li>
              
				<li>
					<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('postFormTag')?> </h4>
                    <span class="pl10 fs13 fshel_midum">3 - 25 words</span> 
                    <span class="red fr pr10 fs13 fshel_midum"><span id="blogWordBox"><?php echo str_word_count($postTagWordsValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($postTagWordsInput); ?>
				</li>
           </ul>
			<ul>
				<li class="icon_2">
					Tag Words do not appear on the site. They help search engines find your work.                                               
				</li>
			</ul>
        </div>
		<?php 
		echo form_input($postIdField); 
		echo form_input($blogIdField);
		echo form_input($blogUserIdField);
		echo form_input($parentPostIdField);
    echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back page
    $data['backPage'] = '/blog/postdisplayimage/'.$postId;
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
                $.post('<?php echo $baseUrl.'/setpostdescdetails';?>',fromData, function(data) {
                    if(data) {
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
</script>
