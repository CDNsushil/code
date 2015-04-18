<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$MW_PRreviewsAddinfo  =str_replace('{{var reviewsAddLink}}','#',$this->lang->line('MW_PRreviewsAddinfo'));?>
<ul class=" fs13 img_text open_semibold pt30 review liststyle_none clearb">
    <?php 
    if(isset($prData) && is_array($prData) && !empty($prData)){
        foreach($prData as $k=>$dt){ 
            $title = $dt['reviewTitle'];
            $prImage = '';
            if((int)$dt['reviewUrlType'] === 1){
               $title = $dt['prtitle']; 
               $smallElementsImg = addThumbFolder($elements[$k]->filePath.$elements[$k]->fileName,'_xxs');
               $imagetype = $this->config->item('defaultReviewsImg_s');
               $src = getImage($smallElementsImg,$imagetype);
               $prImage = '<img class="short w_h_31" alt="image" src="'.$src.'">';
            }
            ?>
            <li id="LI<?php echo $dt['reviewId'];?>">
                <span class="pl77">
                    <?php echo $prImage; ?>
                    <?php echo $title;?>
                    <span class="red fs12 fr">
                        <?php if((int)$dt['reviewUrlType'] !== 1){ ?>
                            <a href="javascript:void(0);" onclick="editPRmetrial('<?php echo $dt['reviewId'];?>','<?php echo $dt['reviewTitle'];?>','<?php echo $dt['reviewExternalUrl'];?>')";><?php echo $this->lang->line('edit');?></a>
                            /
                            <?php
                        }?>
                        <a href="javascript:void(0);" onclick="deleteRecord('AddInfoReviews','reviewId','<?php echo $dt['reviewId']?>','#LI<?php echo $dt['reviewId']?>');";><?php echo $this->lang->line('delete');?></a>
                    </span>
                </span>
            </li>
            <?php
        }
    }
    ?>
    <li class="icon_2 mt30 fs14"><?php echo $MW_PRreviewsAddinfo;?></li>
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
