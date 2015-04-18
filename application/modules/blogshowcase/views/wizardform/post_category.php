<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'postCategoryForm',
    'id'=>'postCategoryForm',
);

$postId = (isset($postData))?$postData->postId:0;
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

<div class="content TabbedPanelsContent width635 m_auto">
   <div class="c_1">
		<?php   
		echo form_open($baseUrl.'/setpostcategory/',$formAttributes); ?>
			<div class="clearb">
				<h3>Select a Category for your Post.</h3>
				<div class="sap_15"></div>
				<ul class="billing_form">
					<li class="select">
						<?php 
						$blogCategoryId = set_value('blogCategoryId')?set_value('blogCategoryId'):$postData->blogCategoryId;
						echo form_dropdown('blogCategoryId', $categoryList, $blogCategoryId,'id="blogCategoryId" class="required" ');
						?>
					</li>
				</ul>
			</div>
			<?php 
			echo form_input($postIdField); 
			echo form_input($blogIdField);
			echo form_input($blogUserIdField);
			echo form_input($parentPostIdField);
		echo form_close();?>
		<div class="clearbox">
			<?php //echo Modules::run("blog/addblogcategory",$postData->blogId);?>
		</div>
	</div>
		
	<!-- Form buttons -->
    <?php 
    // set back page
    $data['backPage'] = '/blog/posttitlendescription/'.$postId;
    // set next form name
    $data['formName'] = 'postCategoryForm';
    
    $this->load->view('wizardform/blog_buttons',$data);
    ?>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
        $("#postCategoryForm").validate({
            submitHandler: function() {
                var fromData=$("#postCategoryForm").serialize();
                
				$.post('<?php echo $baseUrl.'/setpostcategory';?>',fromData, function(data) {
					if(data) {
						window.location.href = data.nextStep; 
					}
				}, "json");
            }
        });
    });
</script>
