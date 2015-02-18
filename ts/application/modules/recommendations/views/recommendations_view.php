<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$loggedUserId=isloginUser();
$beforeRecommendationsLoggedIn=$this->lang->line('beforeRecommendationsLoggedIn');
$name = (isset($name))?$name:'';
$is_show_in_showcase = (isset($is_show_in_showcase) && ($is_show_in_showcase == 't'))?'t':'f';
$is_show_in_cv = (isset($is_show_in_cv) && ($is_show_in_cv == 't'))?'t':'f';
$is_show_in_workrequestclassified = (isset($is_show_in_workrequestclassified) && ($is_show_in_workrequestclassified == 't'))?'t':'f';
if($loggedUserId > 0){
	if($userId==$loggedUserId){
		$recommendFunction="customAlert('".$this->lang->line('cannotRecommendYourself')."')";
	}else{
		$where=array('from_userid'=>$loggedUserId,'to_userid'=>$userId,'is_show_in_showcase'=>'t');
		$countResult=countResult('Recommendations',$where);
		if($countResult > 0){
		   $alreadyRate=$this->lang->line('alreadyRecommended');
		   $recommendFunction="customAlert('".$alreadyRate."')";
		 } else {
			$recommendationsFrom=$this->load->view('recommendations/recommendations_form',array('to_userid'=>$userId,'name'=>$name,'is_show_in_showcase'=>$is_show_in_showcase,'is_show_in_cv'=>$is_show_in_cv,'is_show_in_workrequestclassified'=>$is_show_in_workrequestclassified),true);
			$recommendFunction="if(checkIsUserLogin('".$beforeRecommendationsLoggedIn."')){loadPopupData('popupBoxWp','popup_box',recommendationsFrom)}";?>
			<script>
				var recommendationsFrom=<?php echo json_encode($recommendationsFrom);?>;
			</script><?php 
		}
	}
}else{
	$recommendFunction="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeRecommendationsLoggedIn."')";
}
?>
<button class="review button_c fr fs11" type="button" onclick="<?php echo $recommendFunction;?>">Recommend me </button>
