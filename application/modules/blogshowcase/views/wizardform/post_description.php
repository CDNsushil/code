<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
$formAttributes = array(
    'name'=>'postDescriptionForm',
    'id'=>'postDescriptionForm',
);

$postDescValue = (isset($postData->postDesc))?$postData->postDesc:'';
$postDescInput = array(
    'name'        =>  'postDesc',
    'id'          =>  'postDesc',
    'class'       =>  'ckeditor required',
    'value'       =>  html_entity_decode($postDescValue),
    'tabindex'    =>  "1",
);

$postIdField = array(
    'name'	=> 'postId',
    'value'	=> (isset($postData->postId))?$postData->postId:0,
    'id'	=> 'postId',
    'type'	=> 'hidden'
);

$blodIdField = array(
        'name'	=> 'blogId', 
        'value'	=>  (isset($blogId))?$blogId:0,
        'id'	=> 'blogId',
        'type'	=> 'hidden'
);

$blogUserIdField = array(
        'name'	=> 'blogUserId', 
        'value'	=>  (isset($blogUserId))?$blogUserId:0,
        'id'	=> 'blogUserId',
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
<div class="content TabbedPanelsContent width635 m_auto">
	<?php echo form_open($baseUrl.'/setpostdescription/',$formAttributes);?>
		<div class="c_1">
			<h3><?php echo $this->lang->line('writeYourPost');?></h3>
			<div class="sap_30"></div>
			<div class="editor_wrap">
				<?php echo form_textarea($postDescInput); ?>
			</div>
		</div>	
		<?php 
		echo form_input($postIdField); 
		echo form_input($blodIdField);
		echo form_input($blogUserIdField);
		echo form_input($parentPostIdField);
    echo form_close();?>
    <!-- Form buttons -->
    <?php 
    // set back page
    $data['backPage'] = '/blog/blogmediagallery';
    // set next form name
    $data['formName'] = 'postDescriptionForm';
    $this->load->view('wizardform/blog_buttons',$data);
    ?>
</div>

<script type="text/javascript">
   /**
    * Set Editor's instance for data management
    */
    CKEDITOR.on('instanceReady', function(){
       $.each( CKEDITOR.instances, function(instance) {
        CKEDITOR.instances[instance].on("change", function(e) {
            for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
        });
       });
    });
    

   $(document).ready(function() {
        $("#postDescriptionForm").validate({
            submitHandler: function() {
                var fromData = $("#postDescriptionForm").serialize();
                var postDesc = $("#postDesc").val();
               
                if(postDesc != '') {
					$.post('<?php echo $baseUrl.'/setpostdescription';?>',fromData, function(data) {
						if(data) {
							window.location.href = data.nextStep; 
						}
					}, "json");
				} else {
					alert('Please Write your Post.');
					return false;
				}
            }
        });
    });
</script>
