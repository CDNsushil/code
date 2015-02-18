<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$perPageRecord=(isset($items_per_page) && $items_per_page > 0)?$items_per_page:10;
$totalRecord=(isset($items_total) && $items_total > 0)?$items_total:0;
$pagingWpaerClass=(isset($pagingWpaerClass))?$pagingWpaerClass:'pagination_wrapper new_page_design new_page_design pl10';
$pagingDDDClass=(isset($pagingDDDClass))?$pagingDDDClass:'left_site_dropdown m0 new_page_design new_page_design pr10';
$unqueId=(isset($unqueId))?$unqueId:'';
$isShowNumber=(isset($isShowNumber))?$isShowNumber:true;
$isShowDD=(isset($isShowDD))?$isShowDD:true;
$unqueId=(isset($unqueId))?$unqueId:'full';


?>
<div class="clearfix"></div>
<?php
if($isShowNumber){?>
	<div id="ajaxPagination<?php echo $unqueId;?>"class="<?php echo $pagingWpaerClass;?>">		
		<div class="pagination-button">
			<?php echo $pagination_links ?>
		</div>
	</div>
	<?php
}
if($isShowDD){?>
	<div class="<?php echo $pagingDDDClass;?>">
		<div class="right_site_dropdown dd_desiable">
		  <div class="result_per_page_box">Results per page</div>
		  <div class="bg_sel" > 
			<select id="pagingDropDown<?php echo $unqueId;?>" class="selectBox paginate single width_53" name="myselect2" data-page="1"  >
				  <?php
				  $i=0;
				  while($i < 30){
						$i=$i+5;
						if($i==$perPageRecord){
							$selected='selected';
						}else{
							$selected='';
						}
						echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>'; 
						if($i >= $totalRecord){
							$i++;
						}
				  }
				  ?>
			</select>
		  </div> <!--bg_sel-->
		</div> <!--right_site_dropdown-->
	  </div> <!--right_site_dropdown-->
	<?php
}?>
<script type="text/javascript">
	selectBox();
	var params = {
		page: null,
		ipp: null
	};
	var url<?php echo $unqueId;?> = '<?php echo isset($url)?$url:""?>';
	var container<?php echo $unqueId;?> = '<?php echo isset($divId)?$divId:""?>';
	var formId<?php echo $unqueId;?> = '<?php echo isset($formId)?$formId:0?>';
	$(document).ready(function(){
		$('#ajaxPagination<?php echo $unqueId;?> a').on('click', function() {
			var control = $(this);
			params.page = control.data('page');
			params.ipp = (control.data('ipp')) ? control.data('ipp') : 1;
			params.isdisabled = (control.data('isdisabled')) ? control.data('isdisabled') : 0;
			if(!params.isdisabled){
				
				//alert(url<?php echo $unqueId;?>+container<?php echo $unqueId;?>+formId<?php echo $unqueId;?>);
				
				paginate_request<?php echo $unqueId;?>(url<?php echo $unqueId;?>,container<?php echo $unqueId;?>,formId<?php echo $unqueId;?>);
			}
		});
		$('select#pagingDropDown<?php echo $unqueId;?>').on('change', function() {
			var url<?php echo $unqueId;?> = '<?php echo isset($url)?$url:""?>';
			var control = $(this);
			params.page = control.data('page');
			params.ipp = (control.val()) ? control.val() : 1;
			paginate_request<?php echo $unqueId;?>(url<?php echo $unqueId;?>,container<?php echo $unqueId;?>,formId<?php echo $unqueId;?>);
		});
	});
	function paginate_request<?php echo $unqueId;?>(url<?php echo $unqueId;?>,container<?php echo $unqueId;?>,formId<?php echo $unqueId;?>) {
		var data = 'page='+params.page+'&ipp='+params.ipp+'&ajaxRequest=1';
		$('#'+container<?php echo $unqueId;?>).html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
		if(formId<?php echo $unqueId;?> && formId<?php echo $unqueId;?> != 0){
			if($("#"+formId<?php echo $unqueId;?>)){
				var fromData=$("#"+formId<?php echo $unqueId;?>).serialize();
				data=data+'&'+fromData
			}
		}
		$.post(url<?php echo $unqueId;?>,data, function(data) {
		  if(data){
			 $('#'+container<?php echo $unqueId;?>).html(data);
		  }
		});
	}
</script>
