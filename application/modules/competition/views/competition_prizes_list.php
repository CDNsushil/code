<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<td valign="top">
       <div class="cell right_coloumn bg_black margin_0 bdr10_3b3b3b width778 height1568px">
              <div class="row pl15 pr10 pt7 font_helvetica_L">
              <div class="fl font_size28 clr_white width_420"><?php echo $this->lang->line('CompPrizes'); ?></div>
              <div class="fr width_304 bg_303030 font_size22 text_alignR pr12 height_25"><a href="<?php echo base_url('competition/showcase/'.$userId.'/'.$competitionId); ?>" class="clr_white lineH22"><?php echo $this->lang->line('CompBacktoCompetition'); ?></a> </div>
              <div class="clear"></div>
              <div class="seprator_5"></div>
              <div class="font_size30 clr_white lineH35"><?php echo $competitionData[0]->title; ?></div>
              <div class="clear"></div>
              </div>
              <div class="seprator_5"></div>
        		<?php 
					if($competitionPrizes){
					foreach($competitionPrizes as $competitionPrizesList) {
					
						if(!empty($competitionPrizesList->image) && isset($competitionPrizesList->image))
								$mainCoverImage = $competitionPrizesList->image;
							else
								$mainCoverImage = '';
						$coverImage='';
						$defCoverImage=$this->config->item('defaultcompetitonImg73X110');
						$coverImage = addThumbFolder($mainCoverImage);	
						$prizesImage = getImage($coverImage,$defCoverImage);	
					?>	
			  <div class="bdr6_676767 bg_white ml15 mr12 mt10 position_relative pt13 pb15 pl8 pr8">
              				<div class="scentry_imgcont fl position_relative height220">
                            	<div class="AI_table">
                                <div class="AI_cell">
                                <img alt="img" src="<?php echo $prizesImage; ?>" class="maxh220">
                                </div>
                                </div>
                                <div class="comp_countpa"><?php echo $competitionPrizesList->order; ?></div>
                            </div>
                      		<div class="fl ml34 width_345">
                            		<div class="row font_museoSlab font_size20 clr_bc231b lineH26 mt5"><?php echo $competitionPrizesList->title; ?></div>
                                    <div class="seprator_16"></div>
                                    <div class="row font_helvetica_L font_size16"><?php echo $competitionPrizesList->tagwords; ?>...</div>
                                    <div class="seprator_37"></div>
                                    <div class="row font_helvetica_L font_size13 lineH16"><?php echo $competitionPrizesList->description; ?>...</div>
                            </div>
                      <div class="clear"></div>      
              </div>
              
			<?php } } ?>  		
              
              </div>
</td>
