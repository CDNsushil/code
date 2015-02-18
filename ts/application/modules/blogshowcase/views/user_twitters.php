<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
$openLi = '<li class="p5 maxH50">';
$closeLi = '</li>';
$date_format = 'd F Y';
		
if(isset($feed_data) && !empty($feed_data)){
	
	$valid_data = $feed_data; // Valid data now with just the tweet result.
?>
<div class="row">
<div class="row summery_right_archive_wrapper height25">
<h1 class="sumRtnew_strip clr_white"><?php echo $this->lang->line('recentTweets'); ?></h1>
</div>
</div>
<div class="scroll_box mt11 innershadw backgroundBlack">
	<div class="twiter_birdbg"></div>
	<div class="slider mt3 ml6" id="twitterSlider">
		<a href="#" class="buttons prev disable"></a>
		  <div class="viewport scroll_container02 c5c5c5 width270px">
			<div class="row recent_box_wrapper01 height235 mb4">
			<ul class="overview height480 top0px">			
			<?php
			$ptrclass='';
			$function = '';
			$url = '';
			$onclickShortUrl = '';
    
			$slider2StartFrom =1;
				// Printing out the feed's data in our required format.					
				foreach ($valid_data as $key=>$twitvalue) 
				{					
					//echo '<pre />'.$key;print_r($twitvalue);
					$tweet_time = strtotime($twitvalue['created_at']);						
					if($key<=0) $mt = ' mt10'; else $mt = '';
					
					preg_match( "/http\S+/", $twitvalue['text'], $matches );
					//t.co url for users
					$url = @$matches[0];	
							
					if(isset($twitvalue['in_reply_to_screen_name']) && $twitvalue['in_reply_to_screen_name']!='') 
					{
						$ptrclass='ptr';
						$function = 'onclick="gototwiturl(\'http://twitter.com/'.$twitvalue['in_reply_to_screen_name'].'\');"';
						$userUrl = 'http://twitter.com/'.$twitvalue['user']['screen_name'];						
						$onclickShortUrl = 'onclick="gototwiturl(\''.$url.'\')"';
					}
					else if(isset($twitvalue['user']['screen_name']) && $twitvalue['user']['screen_name']!='') 
					{
						$ptrclass='ptr';
						$function = 'onclick="gototwiturl(\'http://twitter.com/'.$twitvalue['user']['screen_name'].'\');"';
						$userUrl = 'http://twitter.com/'.$twitvalue['user']['screen_name'];						
						$onclickShortUrl = 'onclick="gototwiturl(\''.$url.'\')"';
					}
					else 
					{
						$ptrclass='';
						$function = '';
					}
					
					
					
					echo $openLi;
					?>
					<div class="clear"></div>
					  <div id="twitter-data-container" class="row  <?php echo $mt;?> mH40">
						<div class="cell width225px <?php echo $ptrclass;?> clr_purple gray_clr_hover" <?php echo $function;?> >
							<?php 
								echo getSubString($twitvalue['text'],75); 																	
							?>
						</div>
						<div class="orange_color ptr gray_clr_hover" <?php echo $onclickShortUrl;?> >
							<?php echo $url;?>
						</div>
					  </div>
					  <div class="fr recent_short_txt lH15">
						  <?php echo date($date_format,$tweet_time);?>
					  </div>
					<?php
					echo '<div class="row line1 mb5 mt5"></div>';
					echo $closeLi;						
				}						
			?>
			</ul>
			<div class="clear"></div>
		 </div>
		 </div>
		<a href="#" class="buttons next mb3 mt3"></a>
	</div>
</div>
<div class="mb25"></div>

<script>
	
$(document).ready(function ($) {
	$('#twitterSlider').tinycarousel({ axis: 'y', display: 3, start:1});
});	

function gototwiturl(thisurl)
{
	window.open(
	  thisurl,
	  '_blank' // <- This is what makes it open in a new window.
	);
}

</script>
<?php } 
 ?>
