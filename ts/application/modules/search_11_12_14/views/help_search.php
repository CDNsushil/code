<div class="sidebar_box ml22">
    <!--<div class="sidebar_heading"><h3><?php //echo $this->lang->line('searchTitle'); ?></h3></div>-->
       <div id="search">

            <form method="post" id="searchform" action="<?php echo ''.site_url().'en/help/search'; ?>">
                <fieldset class="search">
               <!-- <input name="search" type="text"  class="search_text_box width_142" PLACEHOLDER="Keyword Search..." />--->
               <input class="search_text_box" type="text" onblur="placeHoderHideShow(this,'Search Tips...','show')" onclick="placeHoderHideShow(this,'Search Tips...','hide')" value="Search Tips..." placeholder="Search Tips..." name="search">
                 <input type="submit" name="searchCrave" value="" class="search_btn_glass formTip" title="Submit Search">
                <!--<button class="btn formTip" title="Submit Search" ><?php //echo $this->lang->line('searchButton'); ?></button>-->
                </fieldset>
            </form>
        </div>
</div>
<div class="clear"></div>
<div class=" seprator_29"></div>
