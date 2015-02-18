<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

$ratingClass = @$ratingClass?$ratingClass:'width_auto pt15 ml5 mt10 Fleft';
$loggedUserId = isloginUser();

$where = array(
	'entityId'=>$entityId,
	'elementId'=>$elementId
);

$res = getDataFromTabel('LogSummary', 'ratingAvg',  $where, '', $orderBy='', '', 1 );

if($res){
	$res=$res[0];
	$ratingAvg=$res->ratingAvg;
}else{
	$ratingAvg=0;
}

$ratingAvg = roundRatingValue($ratingAvg);


	//createDate
	$where = array(
					//'tdsUid'=>$loggedUserId,
					'entityId'=>$entityId,
					'elementId'=>$elementId
				);
	$countResult=countResult('LogRating',$where);
?>

<div class="<?php echo $ratingClass;?>" >
<?php $ratingImg='images/rating/rating_0'.$ratingAvg.'.png';?>
	<img  src="<?php echo base_url($ratingImg);?>" />
</div>
