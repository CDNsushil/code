<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 	
//Common Banner
	 $imgarray['imgarray']=array('banner_front_end02.jpg','banner_front_end05.jpg','banner_front_end04.jpg','banner_front_end03.jpg','banner_front_end06.jpg','banner_front_end.jpg');
	echo $this->load->view('common/common_banner',$imgarray); //common view for image banner placed in main view folder
?>
          <div class="row">
            <div class="cell bdr_purple10 global_shadow bg_white ml40 width_880">
              <!--latest_post_heading-->
              <ul class="wp_news_tab mt11">
                <li class="blogpost_heading width_100"> Latest Posts </li>
              </ul>
             <!-- selectbox-->
             <div class="blog_landing_select">
             	 <select name="myselect0" class=" width_200" id="myselect02" >
                      <option selected="selected">Select Industry</option>
                      <option>Film & Video</option>
                      <option>Music & Audio</option>
                      <option>Photography & Art</option>
                      <option>Writing & Publishing</option>
                      <option>Performances & Events</option>                      
                    </select>
             </div>
              <div class="news_content_wp" >
                <!--Latest_Projects_content_box-->
                <div class="pl10 pr10 pb10 pt7">
                  <div id="slider1" class="slider wp_project_scroll_btn_box "> <a class="buttons next" href="#"></a><a class="buttons prev mr3" href="#"></a>
                    <div class="viewport blog_project_scroll_container">
                      <ul class="overview">
                        <li>
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>"  class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="seprator_10"></div>
                          <!--news_box_cell-->
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="seprator_10"></div>
                          <!--news_box_cell-->
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <!--news_box_cell-->
                        </li>
                        <li>
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="seprator_10"></div>
                          <!--news_box_cell-->
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="seprator_10"></div>
                          <!--news_box_cell-->
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <!--news_box_cell-->
                        </li>
                        <li>
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="seprator_10"></div>
                          <!--news_box_cell-->
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="seprator_10"></div>
                          <!--news_box_cell-->
                          <div class="blog_project_box mr20">
                            <div class="cell width_109 bdr_Rblogpage">
                              <div class="wp_blog_profile_img">
                                <div class="AI_table">
                                  <div class="AI_cell"><img src="<?php echo base_url().'images/blog_profile_img_new.jpg';?>" class="review_thumb" /></div>
                                </div>
                              </div>
                              <div class="wp_blog_profile_name pt12 pb2">Tamara<br />
                                Zelinski-Gruen</div>
                            </div>
                            <!--left text box-->
                            <div class="cell width_265 ml20">
                              <div class="clr_555 lineH13"><b>This is the title of the news</b></div>
                              <div class="wp_blog_profile_date pb9">12 November 2013</div>
                              <div class="clr_555">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated </div>
                              <!--status bar-->
                              <div class="row pt15 font_size10"> <span class="cell blogS_crave_btn min_w20">12</span>
                                <div class="cell mt5 mr20 ">
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                  <div class="rating_box"> </div>
                                </div>
                                <span class=" cell blogS_view_btn">172</span> </div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <!--news_box_cell-->
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="seprator_40"></div>
        </div>

<script type="text/javascript">
/*tab function*/
	$(document).ready(function(){
			$('#slider1').tinycarousel();	
			$('#slider2').tinycarousel();
			$('#slider3').tinycarousel();
			$('#slider4').tinycarousel();
			$('#slider5').tinycarousel();
			
		});
</script>
