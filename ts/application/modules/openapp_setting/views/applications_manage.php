<script type="text/javascript">
$('document').ready(function(){
	$("#app_url").attr("disabled", "disabled"); 
	$("#app_select").change(function(){
		var singleValues = $(this).find(":selected").text();
		$("#app_select").parent().find('#app_selected_text').html(singleValues);
		if(singleValues != '--Select Category--'){
				$("#app_url").removeAttr("disabled"); 
				$('.classic').hide();
			}
		else{
				$("#app_url").attr("disabled", "disabled");
				$('.classic').show();
			}
	});	
	});	
	
function watermark(inputId,text){
  var inputBox = document.getElementById(inputId);
    if (inputBox.value.length > 0){
      if (inputBox.value == text)
        inputBox.value = '';
    }
    else
      inputBox.value = text;
}
</script>

<script type='text/javascript'>
$(function () {
$("#app_url").tooltip({

		// place tooltip on the right edge
		position: "center left",

		// a little tweaking of the position
		offset: [-2, -10],

		// use the built-in fadeIn/fadeOut effect
		//effect: "fade",

		// custom opacity setting
		opacity: 0.7

	});
});
</script>
<div id="columnMidpanel">
	<div class="allappgbox">	
		Add an application by url:<br />
		<form method="get" action="<?php echo base_url(); ?>openapp_setting/addapp">
		<div class="lebelboxui1">
				  <!-- lebel step 1-->
			<span class="app_category">
				<span class="abc dropDownBoxSpan" id="app_selected_text">--Select Category--</span>
					<select class="app_category_select" id="app_select" name="app_category">
							<option>--Select Category--</option>
							<?php foreach($app_categories as $categories):?>
								<option value="<?php echo $categories->id;?>"><?php echo $categories->category_name;?></option>
							<?php endforeach?>
					</select>
			</span>
		</div>
			
		<div class= "inputbox266_new tooltip">
			<input id="app_url" class="required"  type="text" name="appUrl" size="35" id="inputTextboxId" value="Enter App Url" onfocus="watermark('app_url','Enter App Url');" onblur="watermark('app_url','Enter App Url');"/>
			<span class="classic">Please Choose Category first</span>
		</div>
			
			<div class="submit-div">
				<div class="inputbox266"> 
				<span class="saveChange"> 
				<button class="reset" type="submit">
					<span class="button next_bt text_caseL">
						<span class="width_85px" id="save_image">Add Application</span>
					</span>
				</button>
				</span>
				</div>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<div class="ChangingPoints">
<b>Your Applications:</b>
		<?php //echo $this->load->view('userIntro');?>
		<a class="fRight" href="<?php echo base_url(); ?>opensocial/all_application">Browse
		the application directory >></a> <br />
		<br />
		
	
<span class="success_message" id="success"><?php echo $this->session->flashdata('success_app');?></span>
<span class="error_message" id="error"><?php echo $this->session->flashdata('error_app');?></span>

<br />
<br />
		<?php
  if (! count($applications)) {
    echo "You have not yet added any applications to your profile";
  } else {
	 
    foreach ($applications as $app) {
		 $id = $this->session->userdata('user_user_id');
      // This makes it more compatible with iGoogle type gadgets
      // since they didn't have directory titles it seems
      if (empty($app->directory_title) && ! empty($app->title)) {
        $app->directory_title = $app->title;
      }
      echo "<div class=\"app\"><div class=\"options\">";
      if (is_object(unserialize($app->settings))) {
     //   echo "<a href=\"" . base_url() . "/openapp_setting/appsettings/{$app->id}/{$app->mod_id}\"><div class='setting' title='setting'></div></a><br />";
      }
      echo "<a href=\"" . base_url() . "opensocial/app_settings/{$app->id}\"><div class='setting' title='remove'></div></a><br/>";
      echo "<a href=\"" . base_url() . "opensocial/removeapp/".$id."/{$app->id}/{$app->mod_id}\"><div class='remove' title='remove'></div></a><br/>";
	if($app->approved!="Y"){
	echo   "<div class='pending' title='pending'><img src='" . base_url() . "/templates/profile_template/images/pending.png' height='35' width='88'></div>";
	}
	echo "</div>
				<div class=\"app_thumbnail\">";
      if (! empty($app->thumbnail)) {
        // ugly hack to make it work with iGoogle images
        if (substr($app->thumbnail, 0, strlen('/ig/')) == '/ig/') {
          $app->thumbnail = 'http://www.google.com' . $app->thumbnail;
        }
        echo "<img src=\"" . openappConfig::get('gadget_server') . "/gadgets/proxy?url=" . urlencode($app->thumbnail) . "\" />";
      }
      echo "</div><b>{$app->directory_title}</b><br />".substr($app->description,0,50)."";
     
     if($app->approved=="Y"){
			echo "<a href=\"" . base_url() . "opensocial/application/{$app->id}/{$app->mod_id}\">......View More</a>";
		}
	
      $app->author = trim($app->author);
      if (! empty($app->author_email) && !empty($app->author)) {
        $app->author = "<a href=\"mailto: {$app->author_email}\">{$app->author}</a>";
      }
      if (! empty($app->author)) {
        //echo "By {$app['author']}";
      }
     // echo "<br /><div class=\"oauth\">This gadget's OAuth Consumer Key: <i>{$app->oauth->consumer_key}</i> and secret: <i>{$app->oauth->consumer_secret}</i></div>";
      echo Modules::run('like/user_like_form',$app->id,9,$id);
      echo Modules::run('comment',$app->id,9,$id);
      echo "</div>";
    }     echo "</div>";
  }
  ?>
</div>
</div>
<?php
//$this->template('/common/footer.php');
?>
