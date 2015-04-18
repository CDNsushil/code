<div>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr>
	<td style="background-color: #f6f6f6; padding-left: 40px; width: 100%; border-bottom: 1px solid #999999;">
	 <br />

    <?php if ($t->showDaySpanSelector)  {?><div>
    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showDaySpanSelector'))) echo htmlspecialchars($t->showDaySpanSelector());?>
    </div><?php }?>

    <?php if ($t->displayInaccurateStatsWarning)  {?><div class="stats-tz-warning">
        <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showInaccurateStatsWarning'))) echo htmlspecialchars($t->showInaccurateStatsWarning());?>
    </div><?php }?>

    <?php echo $t->scriptOpen;?>

    function getImage() {

       var imageLinkSrc      = document.getElementById('imageLinkSrc');
       var imageLinkSrcTemp  = document.getElementById('imageLinkSrcTemp');

       imageLinkSrc.style.display = 'none';
       imageLinkSrcTemp.style.display = '';

    }

    function showGraph() {

       var imgPath;
       var imageLinkSrc      = document.getElementById('imageLinkSrc');
       var imageLinkSrcTemp  = document.getElementById('imageLinkSrcTemp');
       var graph             = document.getElementById('statsgraph');
       var arrow             = document.getElementById('grapharrow');
       var graphboxes        = document.getElementById('graphboxes');

       if (graph.style.display == 'none') {

            imgPath = '<?php echo $t->aGraphData['tmpUrl'];?>';

            if(imgPath != imageLinkSrc.src) {
                imageLinkSrcTemp.src = imgPath;
                window.setTimeout('getImage()', 3000);
            }

            graph.style.display = 'block';
            graphboxes.style.display = 'block';
            arrow.src = '<?php echo htmlspecialchars($t->aGraphData['imgPath']);?>/triangle-d.gif';

       } else {

            graph.style.display = 'none';
            graphboxes.style.display = 'none';
            arrow.src = '<?php echo htmlspecialchars($t->aGraphData['imgPath']);?>/ltr/triangle-l.gif';

        }
    }
    <?php echo $t->scriptClose;?>

    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr>
    <?php if (!$t->disableGraph)  {?>
		<td style="padding-bottom:5px; white-space: nowrap;">
			<br />
			<a href="stats.php?<?php echo htmlspecialchars($t->aGraphData['queryString']);?>&plugin=advertiser:statshistory" accesskey="e">
            <img src="<?php echo htmlspecialchars($t->assetPath);?>/images/excel.gif" border="0" alt="" /> <?php echo $t->strExportStatisticsToExcel;?>
            </a>
		</td>
		<td width="90%">&nbsp;</td>
	<?php } else {?>
		<td style="padding-bottom:5px; white-space: nowrap;">
			<br />
			<span style="color: #999999;">
            <img src="<?php echo htmlspecialchars($t->assetPath);?>/images/excel.gif" border="0" alt="" /> <?php echo $t->strExportStatisticsToExcel;?></span>
		</td>
		<td width="90%">&nbsp;</td>
	<?php }?>
	</tr>
	</table>
    <div id="statsgraph" style="text-align: center; display:none; background-color:#f9f9f9; border: 1px solid #cccccc; padding: 10px; width: 850px; margin-top: 15px; margin-bottom: 15px;">
	    <?php if ($t->aGraphData['noGraph'])  {?>
	    	<div class='errormessage' style='margin-top: 2em'><img class='errormessage' src='<?php echo htmlspecialchars($t->assetPath);?>/images/info.gif' width='16' height='16' border='0' align='absmiddle'>&nbsp;<?php echo $t->aGraphData['noGraph'];?></div>
	    <?php } else {?>
        <img id="imageLinkSrcTemp" src="" style="display: none;" />
		    <img id="imageLinkSrc" src="<?php echo htmlspecialchars($t->aGraphData['imgPath']);?>/ltr/preloader.gif" style="border: 1px solid #cccccc;padding: 5px;margin: 10px; background-color: #ffffff; text-align:center;" /><form method="post" action="<?php echo htmlspecialchars($t->aGraphData['formSubmitLink']);?>">
		    <div id="graphboxes" style="width: 90%; text-align: left; margin-left: auto; margin-right: auto; display: none; background-color:#eeeeee; padding: 10px; border: 1px solid #cccccc;">
		    <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
		    	<div style="width: 100px; float: left;"><?php 
if (!isset($this->elements['tmpId1']->attributes['value'])) {
    $this->elements['tmpId1']->attributes['value'] = '';
    $this->elements['tmpId1']->attributes['value'] .=  htmlspecialchars($ck);
}
$_attributes_used = array('value');
$element = $this->elements['tmpId1'];
                $element = $this->mergeElement($element,$this->elements['graphFilter[]']);
                echo  $element->toHtml();
if (isset($_attributes_used)) {  foreach($_attributes_used as $_a) {
    unset($this->elements['tmpId1']->attributes[$_a]);
}}
?>&nbsp;<label for="graphFilter_<?php echo htmlspecialchars($ck);?>"><?php echo htmlspecialchars($cv);?></label></div>
		    <?php }?>
      		<input type="Submit" value="Update" style="float: right;" />
		    <br style="clear: both;" />
		    </div>
		    </form>
    	<?php }?>
        <?php if ($t->autoShowGraph)  {?>
            <?php echo $t->scriptOpen;?>
             myvar = showGraph();
            <?php echo $t->scriptClose;?>
        <?php }?>
    </div>
    </td>
  </tr>
  <tr>
	<td style="padding-left: 40px;">
    <?php if ($t->noStatsAvailable)  {?>
    <div class='errormessage' style='margin-top: 2em'><img class='errormessage' src='<?php echo htmlspecialchars($t->assetPath);?>/images/info.gif' width='16' height='16' border='0' align='absmiddle'><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showNoStatsString'))) echo htmlspecialchars($t->showNoStatsString());?></div>
    <?php } else {?>
    <table width="100%" cellspacing="2" class="table">
        <thead>
            <tr>
                <th scope="col" class="aleft"><a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderHrefRev'))) echo htmlspecialchars($t->listOrderHrefRev($t->statsBreakdown));?>"><?php echo htmlspecialchars($t->statsKey);?><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) if ($t->listOrderImage($t->statsBreakdown)) { ?><img src="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'listOrderImage'))) echo htmlspecialchars($t->listOrderImage($t->statsBreakdown));?>" border="0" /><?php }?></a></th>
                <th>&nbsp;</th>
                <?php if ($this->options['strict'] || (is_array($t->weekDays)  || is_object($t->weekDays))) foreach($t->weekDays as $wv) {?><th scope="col" class="acenter"><?php echo htmlspecialchars($wv);?></th><?php }?>
                <th scope="col" class="aright"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strTotal"));?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($this->options['strict'] || (is_array($t->aStatsData)  || is_object($t->aStatsData))) foreach($t->aStatsData as $h) {?>
            <tr class="<?php echo htmlspecialchars($h['htmlclass']['date']);?>">
                <td class="<?php echo htmlspecialchars($h['htmlclass']['date']);?>"><?php echo htmlspecialchars($h['week']);?></td>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['date']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strDate"));?></td>
                <?php if ($this->options['strict'] || (is_array($h['data'])  || is_object($h['data']))) foreach($h['data'] as $hw) {?><td class="<?php echo htmlspecialchars($h['htmlclass']['date']);?> aright separate"><?php echo htmlspecialchars($hw['day']);?></td><?php }?>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['date']);?> aright separate">&nbsp;</td>
            </tr>
            <?php if ($t->showColumns['requests'])  {?><tr class="<?php echo htmlspecialchars($h['htmlclass']['requests']);?>">
                <td class="<?php echo htmlspecialchars($h['htmlclass']['requests']);?>">&nbsp;</td>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['requests']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strRequests"));?></td>
                <?php if ($this->options['strict'] || (is_array($h['data'])  || is_object($h['data']))) foreach($h['data'] as $hw) {?><td class="<?php echo htmlspecialchars($h['htmlclass']['requests']);?> aright separate"><?php echo htmlspecialchars($hw['sum_requests']);?></td><?php }?>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['requests']);?> aright separate"><?php echo htmlspecialchars($h['sum_requests']);?></td>
            </tr><?php }?>
            <?php if ($t->showColumns['views'])  {?><tr class="<?php echo htmlspecialchars($h['htmlclass']['views']);?>">
                <td class="<?php echo htmlspecialchars($h['htmlclass']['views']);?>">&nbsp;</td>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['views']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strImpressions"));?></td>
                <?php if ($this->options['strict'] || (is_array($h['data'])  || is_object($h['data']))) foreach($h['data'] as $hw) {?><td class="<?php echo htmlspecialchars($h['htmlclass']['views']);?> aright separate"><?php echo htmlspecialchars($hw['sum_views']);?></td><?php }?>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['views']);?> aright separate"><?php echo htmlspecialchars($h['sum_views']);?></td>
            </tr><?php }?>
            <?php if ($t->showColumns['clicks'])  {?><tr class="<?php echo htmlspecialchars($h['htmlclass']['clicks']);?>">
                <td class="<?php echo htmlspecialchars($h['htmlclass']['clicks']);?>">&nbsp;</td>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['clicks']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strClicks"));?></td>
                <?php if ($this->options['strict'] || (is_array($h['data'])  || is_object($h['data']))) foreach($h['data'] as $hw) {?><td class="<?php echo htmlspecialchars($h['htmlclass']['clicks']);?> aright separate"><?php echo htmlspecialchars($hw['sum_clicks']);?></td><?php }?>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['clicks']);?> aright separate"><?php echo htmlspecialchars($h['sum_clicks']);?></td>
            </tr><?php }?>
            <?php if ($t->showColumns['ctr'])  {?><tr class="<?php echo htmlspecialchars($h['htmlclass']['ctr']);?>">
                <td class="<?php echo htmlspecialchars($h['htmlclass']['ctr']);?>">&nbsp;</td>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['ctr']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strCTRShort"));?></td>
                <?php if ($this->options['strict'] || (is_array($h['data'])  || is_object($h['data']))) foreach($h['data'] as $hw) {?><td class="<?php echo htmlspecialchars($h['htmlclass']['ctr']);?> aright separate"><?php echo htmlspecialchars($hw['sum_ctr']);?></td><?php }?>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['ctr']);?> aright separate"><?php echo htmlspecialchars($h['sum_ctr']);?></td>
            </tr><?php }?>
            <?php if ($t->showColumns['conversions'])  {?><tr class="<?php echo htmlspecialchars($h['htmlclass']['conversions']);?>">
                <td class="<?php echo htmlspecialchars($h['htmlclass']['conversions']);?>">&nbsp;</td>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['conversions']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strConversions"));?></td>
                <?php if ($this->options['strict'] || (is_array($h['data'])  || is_object($h['data']))) foreach($h['data'] as $hw) {?><td class="<?php echo htmlspecialchars($h['htmlclass']['conversions']);?> aright separate"><a href="stats-conversions.php?<?php echo htmlspecialchars($hw['conversionslink']);?>"><?php echo htmlspecialchars($hw['sum_conversions']);?></a></td><?php }?>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['conversions']);?> aright separate"><?php echo htmlspecialchars($h['sum_conversions']);?></td>
            </tr><?php }?>
            <?php if ($t->showColumns['sr'])  {?><tr class="<?php echo htmlspecialchars($h['htmlclass']['sr']);?>">
                <td class="<?php echo htmlspecialchars($h['htmlclass']['sr']);?>">&nbsp;</td>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['sr']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strCNVRShort"));?></td>
                <?php if ($this->options['strict'] || (is_array($h['data'])  || is_object($h['data']))) foreach($h['data'] as $hw) {?><td class="<?php echo htmlspecialchars($h['htmlclass']['sr']);?> aright separate"><?php echo htmlspecialchars($hw['sum_sr']);?></td><?php }?>
                <td class="<?php echo htmlspecialchars($h['htmlclass']['sr']);?> aright separate"><?php echo htmlspecialchars($h['sum_sr']);?></td>
            </tr><?php }?>
            <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
            <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><tr class="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($h['htmlclass'],$ck));?>">
                <td class="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($h['htmlclass'],$ck));?>">&nbsp;</td>
                <td class="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($h['htmlclass'],$ck));?>"><?php echo htmlspecialchars($cv);?></td>
                <?php if ($this->options['strict'] || (is_array($h['data'])  || is_object($h['data']))) foreach($h['data'] as $hw) {?><td class="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($h['htmlclass'],$ck));?> aright separate">
                    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumnLink'))) if ($t->showColumnLink($hw,$ck)) { ?>
                    <a href="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumnLink'))) echo htmlspecialchars($t->showColumnLink($hw,$ck));?><?php echo htmlspecialchars($hw['linkparams']);?>"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($hw,$ck));?></a>
                    <?php } else {?>
                    <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($hw,$ck));?>
                    <?php }?>
                </td><?php }?>
                <td class="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($h['htmlclass'],$ck));?> aright separate"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($h,$ck));?></td>
            </tr><?php }?>
            <?php }?>
            <?php }?>
        </tbody>
    </table>
    <table width="100%" cellspacing="2" class="table attached-table">
        <tbody>
            <tr>
                <td colspan="<?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'getColSpan'))) echo htmlspecialchars($t->getColSpan());?>" class="nblight" style="padding-bottom: 3em">
                    <div style="float: left">
                        <form method="get">
                            <?php if ($this->options['strict'] || (is_array($t->aPageParams)  || is_object($t->aPageParams))) foreach($t->aPageParams as $pk => $pv) {?>
                            <input type="hidden" name="<?php echo htmlspecialchars($pk);?>" value="<?php echo htmlspecialchars($pv);?>" />
                            <?php }?>
                            <?php if ($t->showDaySpanSelector)  {?>
                            <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strViewBreakdown"));?>:
                            <?php echo $this->elements['statsBreakdown']->toHtml();?>
                            <?php }?>
                            <?php if ($t->pagerSelect)  {?>
                            &nbsp;&nbsp;
                            <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strItemsPerPage"));?>:
                            <?php echo $t->pagerSelect;?>
                            <?php }?>
                        </form>
                    </div>
                    <div style="float: right">
                            <?php if ($t->pagerLinks)  {?>
                            &nbsp;&nbsp;
                            <?php echo $t->pagerLinks;?>
                            <?php }?>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="col" class="aleft">&nbsp;</th>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><th scope="col" class="aright"><?php echo htmlspecialchars($cv);?></th><?php }?>
                <?php }?>
            </tr>
            <tr>
                <td class="last"><b><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'tr'))) echo htmlspecialchars($t->tr("strTotal"));?></b></td>
                <?php if ($this->options['strict'] || (is_array($t->aColumns)  || is_object($t->aColumns))) foreach($t->aColumns as $ck => $cv) {?>
                <?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showColumn'))) if ($t->showColumn($ck)) { ?><td class="aright last"><?php if ($this->options['strict'] || (isset($t) && method_exists($t, 'showValue'))) echo htmlspecialchars($t->showValue($t->aTotal,$ck));?></td><?php }?>
                <?php }?>
            </tr>
        </tbody>
    </table>
    <?php }?>
</div>