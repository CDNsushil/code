<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$MW_PRnewsAddinfo  =str_replace('{{var newsAddLink}}','#',$this->lang->line('MW_PRnewsAddinfo'));?>
<ul class=" fs13 img_text open_semibold pt30 review liststyle_none clearb">
    <?php 
    if(isset($prData) && is_array($prData) && !empty($prData)){
        foreach($prData as $k=>$dt){ 
            $title = $dt['newsTitle'];
            $prImage = '';
            if((int)$dt['newsUrlType'] === 1){
               $title = $dt['prtitle']; 
               $smallElementsImg = addThumbFolder($elements[$k]->filePath.$elements[$k]->fileName,'_xxs');
               $imagetype = $this->config->item('defaultNewsImg_s');
               $src = getImage($smallElementsImg,$imagetype);
               $prImage = '<img class="short w_h_31" alt="image" src="'.$src.'">';
            }
            ?>
            <li id="LI<?php echo $dt['newsId'];?>">
                <span class="pl77">
                    <?php echo $prImage; ?>
                    <?php echo $title;?>
                    <span class="red fs12 fr">
                        <?php if((int)$dt['newsUrlType'] !== 1){ ?>
                            <a href="javascript:void(0);" onclick="editPRmetrial('<?php echo $dt['newsId'];?>','<?php echo $dt['newsTitle'];?>','<?php echo $dt['newsExternalUrl'];?>')";><?php echo $this->lang->line('edit');?></a>
                            /
                            <?php
                        }?>
                        <a href="javascript:void(0);" onclick="deleteRecord('AddInfoNews','newsId','<?php echo $dt['newsId']?>','#LI<?php echo $dt['newsId']?>');";><?php echo $this->lang->line('delete');?></a>
                    </span>
                </span>
            </li>
            <?php
        }
    }
    ?>
    <li class="icon_2 mt30 fs14"><?php echo $MW_PRnewsAddinfo;?></li>
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
