<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'howToPublish',
'id'=>'howToPublish',
);
?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient width_791">
<?php echo form_open(base_url(lang().'/media/howToPublish'),$formAttributes); ?>
	<div class="position_relative ml22">
		<div class="row">
			<div class="font_opensansSBold font_size18 pt10 orange">How To Publish (<?php echo $industryType;?>)</div>
		</div>
		<div class="seprator_22"></div>
		<div class="row">
		  <div>
			<p>Before you can publish a Project you must fill in the Required Fields in:</p>
			<ul>
			<li>1. Event Description;</li> 
			<li>2. Uploads & Pricing; and</li> 
			<li>3. The Project section of Further Description.</li>
			</ul>
			<div class="seprator_22"></div>
			<p>Filling in the fields in the Project section of Further Description creates your "cover": Your online equivalent to a DVD-, album-, book-cover.</p><br/>
			<p>The more information you add to your Project – you can add news, external reviews and interviews in PR Material – the better it will look. After you are happy with how your Project Showcase looks in Preview, press Publish.</p><br/>
			<p>You can come back later and add to, or edit your Project. Information relating to your published Project will be automatically updated, but you need to separately publish each additional Piece you wish to add to your Project.</p><br/>
			<p>You can always use Hide to remove your Project or a Piece from your Showcase for a while.</p><br/>
		  </div>
		</div>
	</div>	
   <?php echo form_close(); ?>
</div>
