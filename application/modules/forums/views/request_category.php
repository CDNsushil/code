<div class="poup_bx  shadow">
        <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
         <?php
            echo form_open('forums/request_sub_cat/', 'class="form" id="requestCategory" name="requestCategory"'); 
        ?>
        <div class="sap_15"></div>
       <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
        <h3 class="">Request a Subcategory</h3>
        <div class="sap_20"></div>
        <ul class="listpb20 width360 list_bg_lable ">
           <li>
            <?php echo form_input($title); ?>
           </li>
           </li>
           <li>
             <?php echo form_textarea($body); ?>
              <p class="pt5 clearb">
                 <span class="">5 - 50 words</span>
                 <span class="fr red"><span id="wordcountid">0</span> words</span>
              </p>
           </li>
        </ul>
       <input type="hidden" name="parent_cat" id="parent_cat" value="<?php echo $parent_cat;?>">
       <button class="mt10" type="submit ">Request</button>
     </div>
       <?php echo form_close(); ?>
  </div>

<script type="text/javascript">
	 $(document).ready(function() {
        // validate the comment form when it is submitted
	   $("#requestCategory").validate({ });
	 });  
</script>
