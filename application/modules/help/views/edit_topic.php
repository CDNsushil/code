<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    echo form_open('help/update_topic', 'class="form" name="edit_topic" id="edit_topic"');
    echo form_hidden('topic_id', $topic_id);
    echo form_hidden('userId', $userId);
    echo form_hidden('comment_id', $comment_id);

?>
<div class="pl20 pr20">
 <div class="fl opens_light red fs24 lineH24  pb10 bbc1c1c1 width100_per">
    Edit Discussion
 </div>
 <ul class="mt35 fl width100_per listpb20">
    <li>
       <label class="width_130 fl">Discussion Title</label>
       <span class="fl"><?php echo form_input($Title); ?></span>
    </li>
    
    <li>
       <label class="width_130 fl">Comment</label>
       <span class="fl"><?php echo form_textarea($Body); ?></span>
    </li>
    
    <?php 
    
        if($this->ion_auth->logged_in())
        {
            if($this->ion_auth->is_admin())
            {
            echo '
            <li>
                
                <h3 class="">'.$this->lang->line('section4Title').'</h3>
                </li>
                
                <li class="padding_0"><div class="defaultP">'.form_checkbox($Close).'</div>'.$this->lang->line('close').''.$this->lang->line('newTopicHintClosed').'</li>';
            }
            if($this->ion_auth->is_group('moderators'))
            {
                if($modsStickyDiscussions == '1' || $modsCloseDiscussions == '1')
                {
                    echo '
                    <li>
                        <h3>'.$this->lang->line('section4Title').'</h3>';
                            if($modsStickyDiscussions == '1')
                            {
                              //  echo ''.form_checkbox($Sticky).''.$this->lang->line('sticky').''.$this->lang->line('newTopicHintSticky').'<br>';
                            }
                            if($modsCloseDiscussions == '1')
                            {
                                echo ''.form_checkbox($Close).''.$this->lang->line('close').''.$this->lang->line('newTopicHintClosed').'<br>';                        
                            }
                    echo '</li>';
                }
            }
            if($this->ion_auth->is_group('members'))
            {
                if($canStickyDiscussions == '1' || $canCloseDiscussions == '1')
                {
                    
                            if($canStickyDiscussions == '1')
                            {
                              //  echo '<div class="defaultP">'.form_checkbox($Sticky).''.$this->lang->line('sticky').'</div>'.$this->lang->line('newTopicHintSticky').'<br>';
                            }
                            if($canCloseDiscussions == '1')
                            {
                              //  echo '<div class="defaultP">'.form_checkbox($Close).''.$this->lang->line('close').'</div>'.$this->lang->line('newTopicHintClosed').'<br>';                        
                            }
                    echo '</li>';                
                }
            }
        }
    ?>
    
    <li class="btn_wrap"><button class="red fr bg_fff" type="submit">Update Discussion</button></li>
 </ul>
 
</div>

<!--<div class="sap_60 mb50 clearb"></div>-->
<?php echo form_close(); ?>


<script type="text/javascript">
     $(document).ready(function() {
        // validate the comment form when it is submitted
       $("#edit_topic").validate({ });
     });  
</script>
