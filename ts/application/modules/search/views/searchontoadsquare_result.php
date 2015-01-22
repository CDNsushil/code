<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<?php
	 $searchResultCount=count($searchResult);
	 if($searchResult && is_array($searchResult) && $searchResultCount > 0){
		 ?>
		<div class="width_458 pt15 pb5"> 
			<div id="pagingContent">
				<?php
				foreach($searchResult as $k=>$search){
					//$search=htmlEntityDecode($search);
					if(isset($searchResult[$k-1]) && (($searchResult[$k-1]->entityid==($searchResult[$k]->entityid)) && ($searchResult[$k-1]->elementid==($searchResult[$k]->elementid)) && ($searchResult[$k-1]->title==($searchResult[$k]->title))  ) ){
								continue;
					}
					$elementid = $search->elementid;
					$projectid = $search->projectid;
					$section = $search->section;
					$title = str_replace(array('"',"'"), array('&quot;',"&apos;"),$search->title);
					
					?>
					<div class="all_list_item">
						<div class="row pl10 pb10">
							<div class="cell defaultP mr20 "> 
								<input type="radio" name="enterPriseName" value="<?php echo $elementid;?>" enterpriseNmae="<?php echo $title;?>" onclick="associatedMembers(this)"  />
							</div>
							<div class="cell mr10 "><?php echo $search->title;?></div>
						</div>
					</div>
					<?php
				}?>
			</div>
		</div>
		<?php
		if($searchResultCount > 50){?>
			  <div class="row pt10 pl15 pr16">
				<?php
					$this->load->view('pagination_view',array('totalRecord'=>$searchResultCount,'record_num'=>50));
				?>
				<div class="clear"></div>
				<div class="seprator_10"></div>
			</div>
			<?php
		}
	}else{
		echo '<div class="pt15">';
		$this->load->view('common/no_search_found');
		echo '</div>';
	}?>
<div class="clear seprator_10"></div>

<div class="clear"></div>
	
	<script>
		function associatedMembers(obj){
			var from_showcaseid = obj.value;
			var searchEnterPrises = $(obj).attr('enterpriseNmae');
			$('#from_showcaseid').val(from_showcaseid);
			$('#searchEnterPrisesDiv').html(searchEnterPrises);
			$('#popup_close_btn').parent().trigger('close');
		}
		runTimeCheckBox();
	</script>
