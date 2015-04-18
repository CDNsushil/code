<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
	$isRecord=false;
	if($elements){
		$imagetype = $fileConfig['defaultImage_m'];
		$imagetype_xs=$fileConfig['defaultImage_xs'];
		$imagetype_s=$fileConfig['defaultImage_s'];
		$method=$methodName=$industryType;
		$thumbFolder='thumb';
		$elementHeading=$elements[0]['projName'];
		$tdsUid=$elements[0]['tdsUid'];
		
		$userInfo =showCaseUserDetails($tdsUid);
		if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
			$creative_name= $userInfo['enterpriseName'];
		}else{
			$creative_name= $userInfo['userFullName'];
		}
		?>
<div class="row content_wrap blog_wrap" >
   <div class="bg_f3f3f3 fl width100_per  title_head">
      <h1 class="fs24imp letrP-1 opens_light mb0  fl  textin30">
          <?php echo $elementHeading;?></h1>
   </div>
   <div class="m_auto display_table wid940">
      <div class="sap_15"></div>
      <div class="pl15 lettsp3">You can access the files via Pay Per View until <b class="red"><?php echo  date("d F Y",strtotime($expiryDate)); ?></b> <?php echo  date("H:i",strtotime($expiryDate)); ?>  <span class="fs11">Luxembourg Time</span>
      </div>
      <div class="sap_30"></div>
        <?php
            $pieceSrartFrom=1;
            $rowCount=2;
            foreach($elements as $e=>$element){
                $fileName=trim($element['fileName']);
                $filePath=trim($element['filePath']);
                $isExternal=trim($element['isExternal']);
                $fpLen=strlen($filePath);
                if($fpLen > 0 && substr($filePath,-1) != '/'){
                    $filePath=$filePath.'/';
                }
                $file=$filePath.$fileName;
                if(is_file($file) || $isExternal=='t'){
                    $isRecord=true;
                    if($industryType=='photographyNart'){
                        if($element['projSellstatus']){
                            $thumbFolder='watermark';
                        }
                        $thumbImage = addThumbFolder($element['filePath'].$element['fileName'],'_xs',$thumbFolder);	
                        $elementImage=getImage($thumbImage,$imagetype_xs,'');
                        $elementImage=$element['isExternal']=='t'?trim($element['filePath']):$elementImage;
                    }else{
                        $thumbImage = addThumbFolder($element['imagePath'],'_xs');	
                        $elementImage=getImage($thumbImage,$imagetype_xs);
                    }
                    $elementTextColor='';
                     
                    $craveCount=$element['craveCount']>0?$element['craveCount']:0;
                    $viewCount =$element['viewCount']>0?$element['viewCount']:0;
                    
                    $cravedALL='';
                    $loggedUserId=isloginUser();
                    if($loggedUserId > 0){
                        $where=array(
                                        'tdsUid'=>$loggedUserId,
                                        'entityId'=>$entityId,
                                        'elementId'=>$element['elementId']
                                    );
                        $countResult=countResult('LogCrave',$where);
                        $cravedALL=($countResult>0)?'cravedALL':'';
                    }else{
                        $cravedALL='';
                    }
                      
                                                
                    $downloadDetails=array(
                                'ownerId'=>$element['tdsUid'],
                                'entityId'=>$entityId,
                                'elementId'=>$element['elementId'],
                                'projectId'=>$element['projId'],
                                'fileId'=>$element['fileId'],
                                'tableName'=>'Project',
                                'primeryField'=>'projId',
                                'elementTable'=>$elemetTable,
                                'elementPrimeryField'=>'elementId',
                                'isElement'=>1,
                                'buyerId'=>$buyerId,
                                'dwnId'=>$dwnId
                    );
                    
                    $downloadDetails=array(
                                'entityId'=>$entityId,
                                'buyerId'=>$buyerId,
                                'dwnId'=>$dwnId,
                                'element'=>$element
                    );
                    $downloadDetailsJson=json_encode($downloadDetails);
                    $varStrig=$entityId.$element['elementId'].$element['projId'];
                    
                    ?>
                <script>
                    var downloadDetailsJson<?php echo $varStrig?>=<?php echo $downloadDetailsJson;?>;
                </script>
                  <!-- box one -->  
                  <div class="border_cacaca p10 wid920 display_inline_block row bg_f7f7f7 mb10">
                     <div class="display_table fl">
                        <div class="table_cell"><img src="<?php echo $elementImage;?>"  class="img_105x59"/></div>
                     </div>
                     <div class="pl20 fr width745 fs16 pr7">	<?php echo getSubString($element['title'],100);?>
                                   <button type="button" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/mediafrontend/playmedia/',downloadDetailsJson<?php echo $varStrig?>);" class="fr mr10 view_btn" >View</button> 
          
                     </div>
                  </div>
      
        <?php
                $rowCount++;
            }
        }
        ?>
     <div class="sap_65"></div>
      <div class="sap_65"></div>
   </div>
</div>
<?php
	}
	
	if(!$isRecord){
		echo '<div class="p10 red">'.$this->lang->line('noRecord').'</div>';
		//redirectToNorecord404();
	} ?>
