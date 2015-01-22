<!--postPreviewBoxWp START  style="display:none; min-height:760px; min-width:760px;"-->
<div id="postPreviewBoxWp" class="postPreviewBoxWp">
	<div id="close-postPreviewBox" title="" class="tip-tr close-customAlert"></div>			
	<div class="postPreviewFormContainer" id="postPreviewFormContainer"></div><!--End Div postPreviewFormContainer-->
</div><!--End Div postPreviewBoxWp-->

<?php 
				//This shows posts related with blog
				echo Modules::run("blog/posts"); 
?>
