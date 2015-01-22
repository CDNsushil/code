<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$MW_PRinterviewsAddinfo  =str_replace('{{var interviewsAddLink}}','#',$this->lang->line('MW_PRinterviewsAddinfo'));?>
<ul class=" fs13 img_text open_semibold pt30 review liststyle_none clearb">
    <?php 
    if(isset($prData) && is_array($prData) && !empty($prData)){
        foreach($prData as $k=>$dt){ 
            $title = $dt['intervTitle'];
            
            ?>
            <li id="LI<?php echo $dt['intervId'];?>">
                <span class="pl20">
                    <?php echo $dt['intervTitle'];?>
                    <span class="red fs12 fr">
                        <a href="javascript:void(0);" onclick="editPRmetrial('<?php echo $dt['intervId'];?>','<?php echo $dt['intervTitle'];?>','<?php echo $dt['intervExternalUrl'];?>')";><?php echo $this->lang->line('edit');?></a>
                            /
                        <a href="javascript:void(0);" onclick="deleteRecord('AddInfoInterview','intervId','<?php echo $dt['intervId']?>','#LI<?php echo $dt['intervId']?>');";><?php echo $this->lang->line('delete');?></a>
                    </span>
                </span>
            </li>
            <?php
        }
    }
    ?>
    <li class="icon_2 mt30 fs14"><?php echo $MW_PRinterviewsAddinfo;?></li>
</ul>
<?php
if(isset($msg) && !empty($msg) ){
    $msgClass = ($error == 1) ? 'errorMsg' : 'successMsg' ; ?>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#messageSuccessError').html('<?php echo '<div class="'.$msgClass.'">'.$msg.'</div>';?>');
        timeout = setTimeout(hideDiv, 5000);
      });
    </script>
    <?php
}
?>
