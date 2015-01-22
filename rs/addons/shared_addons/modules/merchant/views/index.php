<?php defined('BASEPATH') or exit('No direct script access allowed'); 
$userId=is_logged_in();
$this->load->view('page_contents');

?>
<div class="clearfix"></div> 
<div class="title_bg col-sm-12">
	<!--/TITTLE OF PLAN/-->
	<div class="title">Our Subscription Plans</div>
</div>
<?php if(isset($selectFeatures) && !empty($selectFeatures)):
if($this->session->userData('group') == 'admin'){?>
<div class="modal fade" id="membershipPkgEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog content-box">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Update Membership Package</h4>
           </div>
           <div id="membershipPkgForm"></div>
          </div>
    </div>
</div>
<?php }
?>
	
<?php foreach($selectFeatures as $selectFeature):?>
	<?php $membership=$selectFeature['membership']; $features=$selectFeature['features']; ?>
	<?php if(!empty($membership)):?>
		<div class="col-sm-6">
			<div class="merchant_wrapper box_wrapper width_100" style="height:928px;">
                <?php
                if($this->session->userData('group') == 'admin'){ ?>
                    <span class="editTag mr20 t5" title="Edit" onclick="updateMSP('<?php echo $membership->id;?>')"></span>
                    <?php
                }?>
			  <h2 class="price_section"><?php echo $membership->membership_title; ?></h2>
			 
			  <!--/THE PRICE OF PLAN/-->
			  <h1 class="price_section"> <?php if($membership->membership_price!=0): ?><span class="currency">$</span><span><?php echo $membership->membership_price; ?></span> <?php endif;?></h1>
			   <!--/THE MONTH OF PLAN/-->
			  <h3 class="price_section">/<?php echo $membership->membership_days; echo lang('global:days');?></h3>
			  <!--/LIST OF PLANS FEATURES/-->
			 <ul class="box_list">
				 <?php foreach($features as $feature):?>
					<li>
						<b><?php echo $feature->feature_title;  ?></b><br>
						<?php echo $feature->feature_description; ?>
					
					</li>
					
				
				<?php endforeach;?>
			</ul>
		   <?php if(!$userId){ echo anchor('register/id/'.encode($membership->id),lang('global:signup'),'class="btn medium_btn"'); }?>
			</div>
			 <!--/END OF PALN MAIN CONTAINER/-->
		</div>
	<?php endif;?>
 
<?php endforeach; ?>    
<?php endif;?>
<script>
function updateMSP(id){
     var data = 'id='+id;
     var result = ajaxHTML(baseUrl+'membership/membershipForm/','#membershipPkgForm',data);
     if(result){
           $('#membershipPkgEdit').modal({ backdrop: 'static', keyboard: true });
      }
    
}
</script>
