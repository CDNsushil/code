<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$getProfileText =  (isset($getMediaData['getprofileText']) && count($getMediaData['getprofileText']) > 0) ? count($getMediaData['getprofileText']) : 0;
$getProfileAudio =  (isset($getMediaData['getprofileAudio']) && count($getMediaData['getprofileAudio']) > 0) ? count($getMediaData['getprofileAudio']) : 0;
$getProfileImages =  (isset($getMediaData['getprofileImages']) && count($getMediaData['getprofileImages']) > 0) ? count($getMediaData['getprofileImages']) : 0;
$getVideo =  (isset($getMediaData['getvideo']) && count($getMediaData['getvideo']) > 0) ? count($getMediaData['getvideo']) : 0;

//check user profile text

$urlShow ="employePortfolio";
if($getProfileText > 0)
{
	$urlShow = 'employeText';
}
//check user profile audio
if($getProfileAudio > 0)
{
	$urlShow = 'employeAudio';
}
if($getProfileImages > 0)
{
	$urlShow = 'employeImages';
}
if($getVideo > 0)
{
	$urlShow = 'employePortfolio';
}

?>
<?php if($getProfileText > 0 || $getProfileAudio > 0 || $getProfileImages > 0 || $getVideo > 0) { ?>
		<a class="circled_link_box" href="<?php echo base_url()?>workprofilefrontend/<?php echo $urlShow.'/'.$accessUserProfile ?>">
            <div class="seprator_18"></div>
            <div class="portfolio_icon"></div>
            <div class="font_opensansSBold font_size13 text_alignC pt2"><?php echo $this->lang->line('portfolio');?></div>
        </a>
<?php  } ?>



