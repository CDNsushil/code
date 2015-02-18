<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$currentShortUrl = uri_string();
?>

<div class="row content_wrap" >
    <div class=" pl45 pr25 bg_f1f1f1 fl title_head ">
        <h1 class="pt10 mb0  fl">News &amp; Public Relations</h1>
    </div>
    <div class="clearbox bgfcfcfc pt17 pb15">
        <ul class="dis_nav fr pr23 news_list clearb fs16 mt27 open_sans ">
            <li class="active"><a href="javascript:void(0);">Press Releases</a>  </li>
            <li><a href="<?php echo base_url(lang().'/news/index');?>">In The News </a></li>
            <li><a href="<?php echo base_url(lang().'/news/launch_list');?>">Toadsquare Launch </a></li>
            <li><a href="<?php echo base_url(lang().'/news/information_list');?>">Toadsquare Information</a></li>
        </ul>
    </div>
    <div class="width100_per clearb position_relative">
        <a href="<?php echo base_url('pressRelease/index');?>" class="fl close_btn closebig position_absolute"></a>
        <div class="width742 m_auto clearb">
            <div class="sap_45"></div>
            <h3 class="fs24 opens_light bb3_F1592A pt3 pb12 mb20"><?php echo $title;?></h3>
            <div class="date"><?php echo dateFormatView($date,'d F Y');?></div>
            <div class="sap_50"></div>

            <!--Start left contener  --> 
            <div class="width477 pr36 fl left_wrap fs13 lineHp18 ">
                <?php echo changeToUrl($description);?>

                <div class="sap_50 bb_ccc"></div>

                <div class="box_wrap p0 pt20 bdr_non shadownone bg-non press_social">
                    
                    <?php 
                        echo ' <span class="fl">';
                            
                            //-----short module link by email module array-----//
                            $shortlinkEmailData=array('url'=>$currentShortUrl,'isPublished'=>'t','designType'=>'1');
                            echo Modules::run("share/shareemailbutton",$shortlinkEmailData);								
                        
                            //-----load module shortlink module array-----//
                            $shortlinkData=array('url'=>$currentShortUrl,'isPublished'=>'t','designType'=>'1');
                            echo Modules::run("shortlink/shortlinkfrontbuttonnew",$shortlinkData);								
                   
                        echo '</span>';
                            //-------load module of social share---------------//
                            $shareData=array('url'=>$currentShortUrl,'isPublished'=>'t','designType'=>'1');
                            echo Modules::run("share/sharesocialshowview",$shareData);
                    ?>
                    
                </div>
               
            </div>

            <!--End left contener  --> 
            <!--Start right contener  --> 
            <div class="width186 pl41  fl rightbox blcccccc">

                <?php
                $k = $countPR=0;
                if($PressReleaseNewsMaterial){
                    $countPR=count($PressReleaseNewsMaterial);
                    foreach($PressReleaseNewsMaterial as $i=>$matreial){
                        $k++;
                        switch($matreial['fileType']){
                            case 1:
                                $icon='image.png';
                            break;

                            case 2:
                                $icon='video1.png';

                            break;

                            case 3:
                                $icon='icon_music.png';
                            break;

                            case 4:
                                if(strstr($matreial['fileName'], 'pdf') || strstr($matreial['fileName'], 'PDF')){
                                    $icon='adobepdficon.png';
                                }else{
                                    $icon='docsfile.png';
                                }
                            break;

                        }
                        $fileDescription=encode($matreial['fileId']);
                        ?>
                        <div class="fl tac">
                            <a target="_blank" href="<?php echo base_url(lang().'/common/downloadFile/'.$fileDescription);?>">
                            <img src="<?php echo base_url('images/icons/'.$icon);?>" class="pl30" alt="" />
                            <br /><?php echo $matreial['fileTitle']?>
                            </a>
                        </div>
                        <?php
                        if($k < $countPR){
                            echo '<div class="sap_50"></div>'; 
                        }
                    }
                    echo '<div class="sap_65"></div>'; 
                }?>



                <div class="  clr808285 lineHp19 mt5">
                    <b class="red ">Contact for media </b>
                    <div class="sap_20"></div>
                    <p>Gabriela Dvoráková</p>
                    <p>Best Communications</p>
                    <div class="sap_15"></div>
                    <p class="red">Phone Number</p>
                    <p>+420 601 357 066</p>
                    <div class="sap_20"></div>
                    <p class="red"> Email</p>
                    <p><a href="#" class="clr808285">gabriela.dvorakova@bestcg.com</a></p>
                </div>
            </div>
            <!--Start right contener  --> 

            <div class="sap_20"></div>
            <div class="btn_wrap fr">
                <a href="<?php echo base_url('pressRelease/index');?>"><button class=" height40" type="button" > Close</button></a>
                <div class="sap_30"></div>
            </div>
        </div>
    </div>
</div>


<!--<div class="seprator120"></div>-->

<!--End cmslist of title -->
