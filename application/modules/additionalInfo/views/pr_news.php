<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$lang=lang();
$prNewsForm = array(
	'name'=>'prNewsForm',
	'id'=>'prNewsForm'
);

$MW_PRnewsHeading  =str_replace('{{var catType}}',$this->lang->line('catType'.$projCategory),$this->lang->line('MW_PRnewsHeading'));
 
$projId = isset($projId)?$projId:0;
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);


$newsexternalUrlInput = array(
	'name'	=> 'newsexternalUrl',
	'type'	=> 'textarea',
	'id'	=> 'newsexternalUrl',
	'value'	=>isset($newsexternalUrl)?$newsexternalUrl:'',
	'class'	=>'bdr_adadad width612',
    "placeholder"=>"www.example.com",
    "onblur"=>"placeHoderHideShow(this,'www.example.com','show')" ,
    "onclick"=>"placeHoderHideShow(this,'www.example.com','hide')",
);



$newsSearchInput = array(
	'name'	=> 'newsSearch',
	'type'	=> 'text',
	'id'	=> 'newsSearch',
	'value'	=>isset($newsSearch)?$newsSearch:'',
	'class'	=>'font_wN kerywords width_294',
    "placeholder"=>"Keywords",
    "onblur"=>"placeHoderHideShow(this,'Keywords','show')" ,
    "onclick"=>"placeHoderHideShow(this,'Keywords','hide')",
);

 echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'share'.DIRECTORY_SEPARATOR),$prNewsForm); 
    echo form_input($projIdInput);?>
   
<div class="c_1 clearb ">
    <h3 class="fs18 bb_aeaeae letter_sp-P3"><?php echo $MW_PRnewsHeading;?></h3>
    <div class="defaultP  display_inline_block mt40 mb25">
        <label class="link_btn1 mr106"><input type="radio" value="2" name="newsUrlType" checked />Add external URL</label>
        <label class=" serch_btn1"><input type="radio" value="2" name="newsUrlType" />Search Toadsquare</label>
    </div>

    <!--   exterrnal url-->	  
    <div class="link_2">
        <ul class="public">
        <li> 
            <?php echo form_input($newsexternalUrlInput);?>
        </li>
        <li>
        <h3 class="fs21 bb_aeaeae red mt20 mb15"> Ttile</h3>
        <span class="red fs13 fshel_midum">1 - 15 words </span> <span class="red fr  pr10 fs13 fshel_midum">15 words </span>
            <textarea class="bdr_adadad width612 mt10" type="text" name="newstitle" id="newstitle" placeholder="Ttile" value="<?php echo isset($newstitle)?$newstitle:'';?>" onclick="placeHoderHideShow(this,'Ttile','hide')" onblur="placeHoderHideShow(this,'Ttile','show')"></textarea>
        </li>
        </ul>
        <div class="sap_15"></div>																	
        <button class="red fr" type="button">Add </button>

        </div>
        
        
        


    <!--   search-->	 
    <div class="serch_2 dn">
        <ul class="public ">
        <li class="position_relative"><span class="position_relative mr20 mt10 ">
        <?php echo form_input($newsSearchInput);?>
        <input name="Submit" type="submit" class="searchbtbbg" value="Submit"  />
        </span>
        <input class="red p10 mt-5 width_75 bdr_a0a0a0 fshel_bold" type="button" value="Search" /> 
        </li>
        </ul>
        
        

    </div>

<?php echo form_close(); ?>


    <ul class=" fs13 img_text open_semibold pt30 review liststyle_none clearb">
        <li>
        <span class="pl77">
        <img class="short" alt="a" src="images/short_1.jpg">
        This is the title of the media that the user wants to include.
        <span class="red fs12 fr">
        <a href="#"> Edit</a>
        /
        <a href="#">Delete </a>
        </span>
        </span>
        </li>
        <li>
        <span class="pl77">
        This is the title of the media that the user wants to include.
        <span class="red fs12 fr">
        <a href="#"> Edit</a>
        /
        <a href="#">Delete </a>
        </span>
        </span>
        </li>
        <li class="icon_2 mt30 fs14">You can write and upload your own News Articles from <b>Your Toadsquare menu > <a href="">Your News.</a></b> </li>
        </ul>
</div>
                       
    
    

<script type="text/javascript">
  $(document).ready(function(){
	  $("#prNewsForm").validate();
  });
</script>	
