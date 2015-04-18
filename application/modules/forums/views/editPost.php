<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo form_open('forums/update_post/'.$commentID.'', 'class="form" id="editPost" name="editPost"'); 
?>

    

          <div class="pl20 pr20">
             <div class="fl opens_light red fs24 lineH24  pb10 bbc1c1c1 width100_per">
                Edit Post
             </div>
             
              <div class="sap_20"></div>
             
             <div class="comment_form ">
                <?php echo form_textarea($body); ?>
            </div>
            
             <div class="sap_20"></div>
             
            <p class="fs12 "> <?php echo $this->lang->line('hintPostText'); ?></p>

             <ul class="mt20 fl width100_per listpb20">
                <li class="btn_wrap"><button type="submit" class="red fr bg_fff">Update Post</button></li>
             </ul>
             
          </div>
          <!--<div class="sap_60 mb50 clearb"></div>-->
          <!--start pagination--> 
          <!--End pagination--> 
   
<?php echo form_close(); ?>

<script type="text/javascript">
	 $(document).ready(function() {
        // validate the comment form when it is submitted
	   $("#editPost").validate({ });
	 });  
</script>
