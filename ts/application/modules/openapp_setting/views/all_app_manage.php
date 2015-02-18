<script type="text/javascript">
$('document').ready(function(){
	$("#cat_search").change(function(){
		var singleValues = $(this).find(":selected").text();
		$("#cat_search").parent().find('#cat_search_text').html(singleValues);
		});	
	});
</script>

	
	<!-- <div class="allappgbox">	
		<form method="get" action="">
			<div class= "inputbox266_new">
			<input type="text" name="search" size="35" id="inputTextboxId" value="<?php // if($this->input->get('search')){echo $this->input->get('search');}else{?>Search App by Title or description<?php //}?>" onfocus="watermark('inputTextboxId','Search App by Title or description');" onblur="watermark('inputTextboxId','Search App by Title or description');"/>
			</div>
			<div class="lebelboxui1">
				  <!-- lebel step 1- ->
			<span class="app_category">
				<span class="abc dropDownBoxSpan" id="cat_search_text">--Search by category--</span>
					<select class="app_category_select" id="cat_search" name="cat_search">
							<option>--Select Category--</option>
							<?php //foreach($app_categories as $categories):?>
								<option value="<?php //echo $categories->id;?>"><?php //echo $categories->category_name;?></option>
							<?php //endforeach?>
					</select>
			</span>
		</div>
			<div class="search-div">
				<div class="inputbox266"> 
				<span class="saveChange"> 
				<button class="reset" type="submit">
					<span class="button next_bt text_caseL">
						<span class="width_85px search_button" id="save_image">Search</span>
					</span>
				</button>
				</span>
				</div>
			</div>
		</form>
	</div> 
	<div class="clear"></div>-->
	<p class="headingTextOSgames">Games &amp; Apps</p>
	<p class="headingTextOSgames2">Friends playing right now</p>
	<?php echo Modules::run('openapp_setting/friends_playing_now',$user_id); ?>
	<div class='clear'></div>
	<p class="headingTextOSgames2">Apps most used by your friends</p>
	<?php echo Modules::run('openapp_setting/friends_apps_most_using',$user_id); ?>
	<div class="spacer_15"></div>
		
		<div class="clear"></div>
		<div class="spacer_15"></div>
<!-- left box panel-->
	<div class="leftBoxpanel9">
	<p class="headingTextOSgames2">Games and Apps</p>
	<?php
 
	$wahts_new = array_slice($applications, 0, count($applications) / 3);
	$applications = array_slice($applications, count($applications) / 3);
  if (! count($applications)) {
    echo "No approved application";
  } else {
    foreach ($applications as $app) {

      // This makes it more compatible with iGoogle type gadgets
      // since they didn't have directory titles it seems
      if (empty($app->directory_title) && ! empty($app->title)) {
        $app->directory_title = $app->title;
      }
	  $url =  base_url() . "opensocial/application/".$app->id.'/'.$app->mod_id;
	  $app_url = '<a href="'.$url.'" target="_balnk">';
	  ?> <div class="gameAppsbox">
				<div class="gameAppsimgWrap">
      <?php  if (! empty($app->thumbnail)) {
        // ugly hack to make it work with iGoogle images
        if (substr($app->thumbnail, 0, strlen('/ig/')) == '/ig/') {
          $app->thumbnail = 'http://www.google.com' . $app->thumbnail;
        }
        $image = "<img width='68' height='57' src='" . openappConfig::get('gadget_server') . "/gadgets/proxy?url=" . urlencode($app->thumbnail) . "' />";
      echo $app_url.$image.'</a>';
	  }
	/*star rating start*/	 
		$responsetext ='';
		for($i=1;$i<=5;$i++){
			if($app->star_rating >= $i)
				$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'goldstar.png" hspace="1" vspace="0"  alt="'.$app->star_rating.'%"/>';
			else{
				if($i == intval($app->star_rating + .7))
					$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'goldstar.png" hspace="1" alt="'.$app->star_rating.'%"/>';
				else
					$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'sliverstar.png" hspace="1" alt="'.$app->star_rating.'%"/>';
			}
		}
	/*star rating start*/	 
	  
	  ?>
    </div> <div class='color_16GA_os'> <?php echo $app_url.$app->directory_title.'</a>'; ?></div>
			<div class='colorOS2'><?php echo $app->author; ?></div>
    <div class="rattingView"> <?php  echo $responsetext ;?>  </div>
    </div> <?php } //end foreach 
		} //end if 
	?>
</div>
<!-- right box panel-->
<div class="rightBoxpanel9">
			  <p class="headingTextOSgames2" style="padding-left:20px">What&#180;s New</p>
			 <?php
  if (! count($wahts_new)) {
    echo "No approved application";
  } else {
	 
    foreach ($wahts_new as $app) {
      // This makes it more compatible with iGoogle type gadgets
      // since they didn't have directory titles it seems
      if (empty($app->directory_title) && ! empty($app->title)) {
        $app->directory_title = $app->title;
      }
      ?> <div class="gameAppsbox">
				<div class="gameAppsimgWrap">
      <?php if (! empty($app->thumbnail)) {
        // ugly hack to make it work with iGoogle images
        if (substr($app->thumbnail, 0, strlen('/ig/')) == '/ig/') {
          $app->thumbnail = 'http://www.google.com' . $app->thumbnail;
        }
		$url =  base_url() . "opensocial/application/".$app->id.'/'.$app->mod_id;
	  $app_url = '<a href="'.$url.'" target="_balnk">';       
	    $image = "<img width='68' height='57' src='" . openappConfig::get('gadget_server') . "/gadgets/proxy?url=" . urlencode($app->thumbnail) . "' />";
      echo $app_url.$image.'</a>';
      }
	  /*star rating start*/	 
		$responsetext ='';
		for($i=1;$i<=5;$i++){
			if($app->star_rating >= $i)
				$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'goldstar.png" hspace="1" vspace="0"  alt="'.$app->star_rating.'%"/>';
			else{
				if($i == intval($app->star_rating + .7))
					$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'goldstar.png" hspace="1" alt="'.$app->star_rating.'%"/>';
				else
					$responsetext .=  '<img src="'.OPENSOCIAL_IMG.'sliverstar.png" hspace="1" alt="'.$app->star_rating.'%"/>';
			}
		}
	/*star rating start*/	 
	  
	  ?>
     
    </div> <div class='color_16GA_os'> <?php echo $app_url.$app->directory_title.'</a>'; ?></div>
			<div class='colorOS2'><?php  echo $app->author; ?> </div>
     <div class="rattingView"> <?php  echo $responsetext ;?></div> 
     </div>
    <?php } 
} ?>		</div>
			<div class="clear"></div>		
<!-- right box panel end -->
