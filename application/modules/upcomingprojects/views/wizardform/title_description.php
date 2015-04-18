<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'titleNDescForm',
    'id'=>'titleNDescForm',
);

$projTitleValue = set_value('projTitle')?set_value('projTitle'):$upcomingRes['projTitle'];
$projTitleValue = htmlentities($projTitleValue);

$projTitleInput = array(
    'name'        =>  'projTitle',
    'id'          =>  'projTitle',
    'class'       =>  'required width527 min-height_25 mt14 bdr_adadad',
    'value'       =>  html_entity_decode($projTitleValue),
    'wordlength'  =>  "1,15",
    'onkeyup'     =>  "checkWordLen(this,15,'projTitleBox')",
    'placeholder' =>  "Upcoming Media Showcase Title",
    'onBlur'      =>  "placeHoderHideShow(this,'Upcoming Media Showcase Title','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Upcoming Media Showcase Title','hide')"
);

$proShortDescValue = set_value('proShortDesc')?set_value('proShortDesc'):$upcomingRes['proShortDesc'];
$proShortDescValue = htmlentities($proShortDescValue);

$proShortDescInput = array(
    'name'        =>  'proShortDesc',
    'id'          =>  'proShortDesc',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($proShortDescValue),
    'wordlength'  =>  "3,50",
    'onkeyup'     =>  "checkWordLen(this,50,'proShortDescBox')",
    'placeholder' =>  "Upcoming Media Showcase Introduction",
    'onBlur'      =>  "placeHoderHideShow(this,'Upcoming Media Showcase Introduction','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Upcoming Media Showcase Introduction','hide')"
);

$projDescriptionValue = set_value('projDescription')?set_value('projDescription'):$upcomingRes['projDescription'];
$projDescriptionValue = htmlentities($projDescriptionValue);

$projDescriptionInput = array(
    'name'        =>  'projDescription',
    'id'          =>  'projDescription',
    'class'       =>  'font_wN width_615 red_bdr_2 mt16 height150',
    //'title'       =>  $this->lang->line('TheseWordsImprove'),
    'value'       =>  html_entity_decode($projDescriptionValue),
    'wordlength'  =>  "0,200",
    'onkeyup'     =>  "checkWordLen(this,200,'projDescriptionBox')",
    'placeholder' =>  "About the Upcoming Media Showcase",
    'onBlur'      =>  "placeHoderHideShow(this,'About the Upcoming Media Showcase','show')",
    'onClick'     =>  "placeHoderHideShow(this,'About the Upcoming Media Showcase','hide')"
);

$projTagValue = set_value('projTag')?set_value('projTag'):$upcomingRes['projTag'];
$projTagValue = htmlentities($projTagValue);

$projTagInput = array(
    'name'        =>  'projTag',
    'id'          =>  'projTag',
    'class'       =>  'required font_wN width_615 red_bdr_2 mt16 height51',
    'value'       =>  html_entity_decode($projTagValue),
    'wordlength'  =>  "3,25",
    'onkeyup'     =>  "checkWordLen(this,25,'projTagBox')",
    'placeholder' =>  "Tag Words",
    'onBlur'      =>  "placeHoderHideShow(this,'Tag Words','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Tag Words','hide')"
);

$projectIdField = array(
	'name'	=> 'projId',
	'value'	=> (isset($upcomingRes['projId'])) ? $upcomingRes['projId'] : 0,
	'id'	=> 'projId',
	'type'	=> 'hidden'
);
   
// set base url
$baseUrl = base_url(lang().'/upcomingprojects/');
?>

<div class="content display_table TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/setpostdescdetails/',$formAttributes); 
    ?>
		<div class="c_1 clearb">
			<ul class="form_img mt25 mb25">
				<li>
					<h4 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('upcomingTitle')?> </h4>
					 <span class="pl10 fs13 fshel_midum">1 - 15 words</span> 
					 <span class="red fr fs13 fshel_midum"><span id="projTitleBox"><?php echo str_word_count($projTitleValue);?></span>  <span>words</span> </span></label>
					<?php echo form_input($projTitleInput); ?>
                </li>
                
                <li>
                    <h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('upcomingItroduction')?> </h4>
                    <span class="pl10 fs13 fshel_midum">3 - 50 words</span> 
                    <span class="red fr pr10 fs13 fshel_midum"><span id="proShortDescBox"><?php echo str_word_count($proShortDescValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($proShortDescInput); ?>
                </li>
				
				<li>
                    <h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('upcomingDesc')?> </h4>
                    <span class="pl10 fs13 fshel_midum">0 - 200 words</span> 
                    <span class="red fr pr10 fs13 fshel_midum"><span id="projDescriptionBox"><?php echo str_word_count($projDescriptionValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($projDescriptionInput); ?>
                </li>
              
				<li>
					<h4 class="red fs21  bb_aeaeae"> <?php echo $this->lang->line('upcomingTagWords')?> </h4>
                    <span class="pl10 fs13 fshel_midum">3 - 25 words</span> 
                    <span class="red fr pr10 fs13 fshel_midum"><span id="projTagBox"><?php echo str_word_count($projTagValue);?></span>  <span>words</span> </span></label>
                    <?php echo form_textarea($projTagInput); ?>
				</li>
           </ul>
			<ul>
				<li class="icon_2">
					Tag Words do not appear on the site. They help search engines find your work.                                               
				</li>
			</ul>
        </div>
    <?php 
		echo form_input($projectIdField); 
    echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set next form name
    $data['formName'] = 'titleNDescForm';
    
    $this->load->view('wizardform/donation_buttons',$data);
    ?>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
        $("#titleNDescForm").validate({
            submitHandler: function() {
                var fromData=$("#titleNDescForm").serialize();
                $.post('<?php echo $baseUrl.'/settitlendescription';?>',fromData, function(data) {
                    if(data) {
                       window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
</script>
