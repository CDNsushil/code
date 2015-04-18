<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/jquery-plugin/tipsy-1.0/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>templates/system/javascript/common/tipsy-common.js"></script>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	if(isset($dataProject[$imageField]) && !empty($dataProject[$imageField]) && ($elemetTable != 'PaElement')){
		if(is_file($dataProject[$imageField])){
			$src=getImage($dataProject[$imageField]);
		}else{
			$src=isset($src)?$src:'';
		}
	}
	
	$Data=array(
				'entityId'=>$entityId,
				'title'=>$title,
				'fileLength'=>$fileLength,
				'imgSrc'=>$src,
				'rawFileName'=>@$dataProject['rawFileName'],
				'tags'=>@$dataProject['tags'],
				'description'=>@$dataProject['description'],
				'productionCompany'=>@$dataProject['productionCompany'],
				'elementId'=>$elementId
			  );
	$jsonData=json_encode($Data);
	?>
	<script>
		var data<?php echo $elementId;?> = <?php echo $jsonData;?>;
	</script>

<div class="extract_img_wp"> 
	<img class="formTip ptr maxWH30 ma" src="<?php echo $src;?>" title="<?php echo $title; ?>" />
</div>
<!--extract_img_wp-->
<div class="extract_heading_box"> <?php echo getSubString($title,25); ?> </div>
<!--extract_heading_box-->
<div class="extract_quota_box"> <?php echo $fileLength; ?> </div>

<div class="extract_button_box">
  <div class="small_btn"><a href="javascript:void(0)" onclick="changeFurtherDescriptionFormValue(data<?php echo $elementId;?>)"><div class="cat_smll_edit_icon"></div></a></div>
</div>
