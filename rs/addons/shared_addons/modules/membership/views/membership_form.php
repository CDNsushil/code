<?php    defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="item">
		<form action="<?php echo base_url('membership/saveMembership/');?>" id="MSform" method="post" accept-charset="utf-8">
		<div class="modal-body">
            <div class="form_inputs">
                <ul>
                    <li>
                        <label for="title"><?php echo lang('membership:title');?> <span>*</span></label>
                        <div class="input"><?php echo form_input('membership_title', $membership->membership_title, 'required');?></div>
                    </li>
                    
                    <li class="even">
                        <label for="price"><?php echo lang('membership:price');?> <span>*</span></label>
                        <div class="input">
                            <?php echo form_input('membership_price', $membership->membership_price, 'required class="validPrice numeric"');?>
                            <span class="error pr"></span>
                        </div>
                    </li>
                    <li>
                        <label for="membership_status"><?php echo lang('membership:status');?> <span>*</span></label>
                        <div class="input">
                            <?php
                                  $selected=$membership->membership_status;
                                  $titleArray=array(lang('membership:enabled'),lang('membership:disabled'));
                                  $other='class="" id="membership_status" ';
                                  echo form_dropdown('membership_status',$titleArray, $selected, $other);
                              ?>
                            </div>
                    </li>
                    
                        <li>
                        <label for="membership_days"><?php echo lang('membership:membership_days');?> <span>*</span></label>
                        <div class="input">
                            <?php
                            
                                  $selected=$membership->membership_days;
                                  $titleArray=array(''=>lang('membership:membership_day_select'),'15'=>15,'30'=>30,'45'=>45,'60'=>60,'90'=>90,'120'=>120,'180'=>180,'270'=>270,'365'=>365);
                                  $other='class="" id="membership_days" ';
                                  echo form_dropdown('membership_days',$titleArray, $selected, $other);
                              ?>
                            </div>
                    </li>
                    
                    <li class="even">
                        <label for="membership_features"><?php echo lang('membership:membership_features');?> <span></span></label>
                        <div class="membership_div">
                            <?php 
                                if(isset($features) && !empty($features)){
                                    foreach($features as $feature){
                                        $selected='';
                                        if(isset($selectFeatures) && !empty($selectFeatures)){
                                            foreach($selectFeatures as $select){
                                                if($select->feature_id==$feature->id){
                                                    $selected='true';
                                                }
                                            }
                                        }
                                        $featureDescription=$feature->feature_description;
                                        $checkField = array(
                                            'name'			=> 'membership_features[]',
                                            'value'			=> $feature->id,
                                            'checked'		=> $selected,
                                            'type'			=> 'checkbox',
                                            'title'			=> $featureDescription
                                        );
                                        $other=$selected;
                                        echo '<div class="feature_div">'.form_checkbox($checkField);
                                        echo "<span class='feature_span'>".$feature->feature_title."</span></div>";
                                    }
                                }
                                ?>
                                <div class="clear"></div>
                        </div>
                    </li>
                    <li>
                        <label for="description"><?php echo lang('membership:description');?> <span></span></label>
                        <div class="input"><?php echo form_textarea	('membership_description', $membership->membership_description);?></div>
                    </li>
                    
                </ul>
            </div>
        </div>
        <div class="modal-footer text-center">
          <input type="hidden" value="<?php echo $membership->id;?>" name="id">
         <button data-dismiss="modal" class="btn btn-primary col-xs-12 btn-custom" type="button">Close</button>
         <button class="btn btn-primary col-xs-12 btn-custom" type="submit">Save</button>
      </div>	
     </form>
</section>

<script>
$( document).ready(function() {
    $(".validPrice").keypress(function(e) {
		 
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)) && e.which!=46)
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('Please enter valid Price.');
				formError=true;
				return false;
			}	
			
			$(this).next('span').fadeOut(2000);
		});
		$(".validPrice").blur(function(e) {
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)) && e.which!=46)		{
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid Price.');
			formError=true;
			return false;
		}	
		formError=false;
		$(this).next('span').fadeOut(2000);
	});
    
    $( "#MSform" ).submit(function( event ) {
        postFormGetHTML('#MSform','','.close','',1);
        return false;
        event.preventDefault();
    });
    
});

</script>

