
		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>player/FlexPaper_new/css/flexpaper.css" />
		<script type="text/javascript" src="<?php echo base_url();?>player/FlexPaper_new/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>player/FlexPaper_new/js/jquery.extensions.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>player/FlexPaper_new/js/flexpaper.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>player/FlexPaper_new/js/flexpaper_handlers.js"></script>
		
        <div id="documentViewer" class="flexpaper_viewer" style="position:absolute;left:10px;top:10px;width:770px;height:500px"></div>

        <script type="text/javascript">
           
            var startDocument = "Paper";

            $('#documentViewer').FlexPaperViewer(
                   { config : {

                     SWFFile : '<?php echo base_url();?>media/JBshdrAX/workshowcase/WrittenMaterial/converted/p17j70lunt14n7bsbo1fg5hlihd.swf',
                     Scale : 0.6,
                     ZoomTransition : 'easeOut',
                     ZoomTime : 0.5,
                     ZoomInterval : 0.1,
                     FitPageOnLoad : true,
                     FitWidthOnLoad : false,
                     FullScreenAsMaxWindow : false,
                     ProgressiveLoading : false,
                     MinZoomSize : 0.2,
                     MaxZoomSize : 5,
                     SearchMatchAll : false,
                     InitViewMode : 'Portrait',
                     RenderingOrder : 'flash,html',
                     StartAtPage : '',
                     PrintPaperAsBitmap : false,

                     ViewModeToolsVisible : true,
                     ZoomToolsVisible : true,
                     NavToolsVisible : true,
                     CursorToolsVisible : true,
                     SearchToolsVisible : true,
                     WMode : 'window',
                     localeChain: 'en_US'
                   }}
            );
        </script>

  
