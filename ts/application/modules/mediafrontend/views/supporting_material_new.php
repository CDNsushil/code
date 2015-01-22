<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
if($suportLinks && is_array($suportLinks) && count($suportLinks) > 0){
	?>
		 
    <div class="box_wrap  fl width250 ">
        <h4 class=" mb16 red font_bold whitespace_now ml-10"><?php echo $this->lang->line($industryType.'_associated_media'); ?></h4>
        <div id="supporting_slider" class="slider vertical_slide width250">
           <a class="buttons prev" href="#"><img src="<?php echo $imgPath; ?>arrow_top.png" alt="" /> </a>
           <div class="viewport height140 ">
              <ul class="img_box overview  width250">
                    
                <?php
                    foreach($suportLinks as $k=> $links)
                    {
                       if(!empty($links['title'])){
                        $supportingImage=$links['image'];
                        $section=$links['section'];
                        if($section=='filmNvideo' || strstr($section,'FvElement')){
                            $sectionHeading=$this->lang->line('filmNvideo');
                            $imagetype = $this->config->item('filmNvideoImage_xxs');
                        }
                        elseif($section=='musicNaudio' || strstr($section,'MaElement')){
                            $sectionHeading=$this->lang->line('musicNaudio');
                            $imagetype = $this->config->item('musicNaudioImage_xxs');
                        }
                        elseif($section=='photographyNart' || strstr($section,'PaElement')){
                            $sectionHeading=$this->lang->line('photographyNart');
                            $imagetype = $this->config->item('photographyNartImage_xxs');
                        }
                        elseif($section=='writingNpublishing' || strstr($section,'WpElement')){
                            $sectionHeading=$this->lang->line('writingNpublishing');
                            $imagetype = $this->config->item('writingNpublishingImage_xxs');
                        }
                        elseif($section=='educationMaterial' || strstr($section,'EmElement')){
                            $sectionHeading=$this->lang->line('educationMaterial');
                            $imagetype = $this->config->item('educationMaterialImage_xxs');
                        }
                        elseif(strstr($section,'Events')){
                            $sectionHeading=$this->lang->line('event');
                            $imagetype = $this->config->item('defaultEventImg_xxs');
                        }
                        elseif(strstr($section,'Launch')){
                            $sectionHeading=$this->lang->line('launch');
                            $imagetype = $this->config->item('defaultEventImg_xxs');
                        }
                        else{
                            $sectionHeading='';
                            $imagetype = '';
                            
                        }
                        
                        $link=getFrontEndLink($links['entityid_from'],$links['elementid_from']);
                        
                        $supportingImage=addThumbFolder($supportingImage,$suffix='_xxs',$thumbFolder ='thumb',$defaultThumb=$imagetype);
                        if(strstr($section,'PaElement') && $links['fileId']){
                            $fileDetails=getDataFromTabel('MediaFile', $field='*',  $whereField='fileId', $links['fileId'], $orderBy='', $order='', $limit=1 );
                            if($fileDetails){
                                $file=$fileDetails[0];
                                if($file->isExternal=='t'){
                                        $supportingImage=($file->filePath!='')?$file->filePath:'';
                                }else{
                                    $supportingImage=$file->filePath.=$file->fileName;
                                    $supportingImage=addThumbFolder($supportingImage,$suffix='_xxs',$thumbFolder ='thumb',$defaultThumb=$imagetype);
                                }
                            }
                        }
                        $supportingImage=getImage($supportingImage,$imagetype);
                        
                        ?>
                        <a target="_blank" href="<?php echo $link;?>">
                            <li>
                                <div class="table_cell img_thum"><img src="<?php echo $supportingImage;?>" alt="" /></div>
                                <div class="ml28">
                                   <h4> <?php echo $sectionHeading;?></h4>
                                   <p><?php echo string_decode($links['title']);?></p>
                                </div>
                             </li>
                        </a>
                        <?php
                    }
                }
                ?>
              </ul>
           </div>
           <a class="buttons next" href="#"><img src="<?php echo $imgPath; ?>arrow_bottom.png" alt="" /></a> 
        </div>
     </div>
     
    <script type="text/javascript">
        $(document).ready(function(){
            $('#supporting_slider').tinycarousel({ axis: 'y', display: 1});	
        });
    </script> 

     
	<?php
}?>

<div class="sap_25"></div>
