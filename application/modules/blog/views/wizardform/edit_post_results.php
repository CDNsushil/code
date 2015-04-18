<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$isRemove = false;
$isArchive = 'f';
if(isset($isDeletedSection)) {
	$isRemove = true;
	$isArchive = 't';
}
// get category id
$categoryId   = (!empty($catId)) ? $catId : 0;
$archiveMonth = (isset($archiveMonth)) ? $archiveMonth : '';
$archiveYear  = (isset($archiveYear)) ? $archiveYear : '';
?>

<!--Collection list One-->
<div class="left_wrap fr width706 ">			
	<!--blog_post-->
	<?php 
	foreach($postResults as $post) {
		
		// get post view, crave and rate counts
		$viewCount = 0;
		$craveCount = 0;
		$ratingAvg = 0;
		$isArchive= $post->postArchived;
		$LogSummarywhere = array(
					'entityId'=>$entityId,
					'elementId'=>$post->postId
		);
		$resLogSummary = getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
		if($resLogSummary)
		{
			$resLogSummary = $resLogSummary[0];
			$viewCount = $resLogSummary->viewCount;
			$craveCount = $resLogSummary->craveCount;
			$ratingAvg = $resLogSummary->ratingAvg;
		}else
		{
			$viewCount = 0;
			$craveCount = 0;
			$ratingAvg = 0;
		}
		
		$ratingAvg = roundRatingValue($ratingAvg);
		$ratingImg = base_url('images/rating/rating_0'.$ratingAvg.'.png'); 

		// get post image url
		$postImagePath = getBlogImage($post,0);
		
		// set post view url
		$showcaseViewUrl = '/blogshowcase/frontPostDetail/'.$post->custId.'/'.$post->postId;
		if($post->isPublished == 'f') {
			$showcaseViewUrl = '/blogshowcase/preview/'.$post->custId.'/'.$post->postId.'/frontPostDetail';
		}
		?>
		<div class="border_cacaca width100_per height225 display_table position_relative">
			<span class="table_cell edit_thum verti_top width228 bg_f6f6f6" >
				<img src="<?php echo $postImagePath;?>" alt=""  />
				<?php if($isRemove == false && $post->isPublished == 'f' && $post->postArchived == 'f') { ?>
					<a href="<?php echo base_url(lang().'/blog/previewnpublishpost/'.$post->postId)?>">
						<button type="button" class="red fs13">Publish Post in Showcase</button>
					</a>
				<?php } ?>
				<?php if($isRemove == false && $post->isPublished == 't' && $post->postArchived == 'f') { ?>
					<a href="<?php echo base_url(lang().'/blog/previewnpublishpost/'.$post->postId)?>">
						<button type="button" class="red fs13">Hide Post in Showcase</button>
					</a>
				<?php } ?>
				<?php if($post->postArchived == 't' && $post->isBlocked == 't') { ?>
					<div class="acccses_suspended width228">
						<div class="pl20 pr20 text_alighL pt25">
							<p>Another member of Toadsquare has declared that they believe that the material is illegal. Please see your email and Tmail for more details.</p>
							<div class="sap_20"></div>
							<p>Access to this material has been suspended.</p>
						</div>
					</div>
				<?php } ?>
			</span>
			<div class="display_inline width417 fr ml36 pb15 mr25">
				<div class="clearbox pt15">
					<div class="fr">
						<a href="javascript:void(0);" onclick="movePostToArchive('<?php echo $post->postId;?>')">
							<button type="button" class="bg_ededed mr6">Delete</button>
						</a>
						
						<?php if( $isRemove == true && $post->postArchived == 't') { ?>
							<a href="javascript:void(0);" onclick="moveFromArchive('','Posts','postId','<?php echo $post->postId; ?>','postArchived','/blog/editposts','','','','');" >
								<button type="button" class="b_F1592A">Restore</button>
							</a>
						<?php } else {?>
							<a href="<?php echo base_url(lang().'/blog/addpost/'.$post->postId)?>">
								<button type="button" class="b_F1592A">Edit</button>
							</a>
						<?php } ?>
						
					</div>
				</div>
				<div class="sap_30"></div>
				<div class="clearbox" >
					<h4 class="fs18 min_H62">
						<?php echo $post->postTitle;?>
					</h4>
				</div>
				<div class="sap_45"></div>
				<div class="">
					<?php if( $isRemove == false && $post->postArchived == 'f' && $post->isBlocked == 'f') { ?>
						<div class="fl">
							<a href="<?php echo base_url(lang().$showcaseViewUrl);?>" class="color_444 org_link_hover">View Post in Showcase  <span class="red pl5">></span></a> 
						</div>
					<?php } ?>
					<div class="head_list fr pr12">
						<div class="icon_view3_blog icon_so"><?php echo $viewCount?></div>
						<div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
						<div class="rating fl mt5"><img src="<?php echo $ratingImg;?>"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="sap_15"></div>
		
	<?php } ?>
	<div class="sap_60"></div>	
	<?php 
if($items_total >  $perPageRecord) { ?>
    <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/blog/editpostresult/0/'.$isArchive.'/'.$categoryId.'/'.$archiveMonth.'/'.$archiveYear),"divId"=>"searchontoadsquareResultDiv","formId"=>"searchontoadsquare","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
    <div class="seprator_10 clear"></div>
<?php } ?>
</div>	


<!-- End Content wrap  --> 

<script type="text/javascript">
	function movePostToArchive(postId) {
		
		var isRemove = '<?php echo $isRemove;?>';
		var confirmText = 'If you delete this, it will be stored in Deleted & Expired Tools for one month.';
		
		if(isRemove == true ) {
			confirmText = 'If you delete this, it will be deleted immediately.';
		}
		confirmBox(confirmText, function () {
			var fromData='postId='+postId+'&isRemove='+isRemove;
			 $.post(baseUrl+language+'/blog/moveposttoarchive',fromData, function(data) {
				if(data.deleted) {
					refreshPge();
				}
			},'json');
		});
	}
</script>
