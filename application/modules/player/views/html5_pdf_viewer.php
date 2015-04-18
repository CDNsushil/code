<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

echo '<html dir="ltr" mozdisallowselectionprint moznomarginboxes>
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>PDF.js viewer</title>

<!--#if FIREFOX || MOZCENTRAL-->
<!--#include viewer-snippet-firefox-extension.html-->
<!--#endif-->

    <link rel="stylesheet" href="'.base_url('player/html5_pdf_viewer/web/viewer.css').'"/>
<!--#if !PRODUCTION-->
    <link rel="resource" type="application/l10n" href="locale/locale.properties"/>
<!--#endif-->

<!--#if !(FIREFOX || MOZCENTRAL || CHROME)-->
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/web/compatibility.js').'"></script>
<!--#endif-->

<!--#if !PRODUCTION-->
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/web/l10n.js').'"></script>
<!--#endif-->

<!--#if !PRODUCTION-->
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/network.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/chunked_stream.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/pdf_manager.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/core.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/util.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/api.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/metadata.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/canvas.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/obj.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/annotation.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/function.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/charsets.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/cidmaps.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/colorspace.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/crypto.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/evaluator.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/fonts.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/font_renderer.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/glyphlist.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/image.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/metrics.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/parser.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/pattern.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/stream.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/worker.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/external/jpgjs/jpg.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/jpx.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/jbig2.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/src/bidi.js').'"></script>
    <script type="text/javascript">PDFJS.workerSrc = "'.base_url('player/html5_pdf_viewer/src/worker_loader.js').'";

	//PDF File URL Here	
	var DEFAULT_URL =  "'.base_url().$pdfFilePath.'/'.$pdfFileName.'";

    
    </script>
<!--#endif-->

<!--#if GENERIC || CHROME-->
<!--#include viewer-snippet.html-->
<!--#endif-->

    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/web/debugger.js').'"></script>
    <script type="text/javascript" src="'.base_url('player/html5_pdf_viewer/web/viewer.js').'"></script>
  </head>

  <body tabindex="1">
    <div id="outerContainer" class="loadingInProgress">

      <div id="sidebarContainer">
        <div id="toolbarSidebar">
          <div class="splitToolbarButton toggled">
            <button id="viewThumbnail" class="toolbarButton group toggled" title="Show Thumbnails" tabindex="2" data-l10n-id="thumbs">
               <span data-l10n-id="thumbs_label">Thumbnails</span>
            </button>
            <button id="viewOutline" class="toolbarButton group" title="Show Document Outline" tabindex="3" data-l10n-id="outline">
               <span data-l10n-id="outline_label">Document Outline</span>
            </button>
          </div>
        </div>
        <div id="sidebarContent">
          <div id="thumbnailView">
          </div>
          <div id="outlineView" class="hidden">
          </div>
        </div>
      </div>  <!-- sidebarContainer -->

      <div id="mainContainer">
        <div class="findbar hidden doorHanger hiddenSmallView" id="findbar">
          <label for="findInput" class="toolbarLabel" data-l10n-id="find_label">Find:</label>
          <input id="findInput" class="toolbarField" tabindex="21">
          <div class="splitToolbarButton">
            <button class="toolbarButton findPrevious" title="" id="findPrevious" tabindex="22" data-l10n-id="find_previous">
              <span data-l10n-id="find_previous_label">Previous</span>
            </button>
            <div class="splitToolbarButtonSeparator"></div>
            <button class="toolbarButton findNext" title="" id="findNext" tabindex="23" data-l10n-id="find_next">
              <span data-l10n-id="find_next_label">Next</span>
            </button>
          </div>
          <input type="checkbox" id="findHighlightAll" class="toolbarField">
          <label for="findHighlightAll" class="toolbarLabel" tabindex="24" data-l10n-id="find_highlight">Highlight all</label>
          <input type="checkbox" id="findMatchCase" class="toolbarField">
          <label for="findMatchCase" class="toolbarLabel" tabindex="25" data-l10n-id="find_match_case_label">Match case</label>
          <span id="findMsg" class="toolbarLabel"></span>
        </div>
        <div class="toolbar">
          <div id="toolbarContainer">
            <div id="toolbarViewer">
              <div id="toolbarViewerLeft">
                <button id="sidebarToggle" class="toolbarButton" title="Toggle Sidebar" tabindex="4" data-l10n-id="toggle_sidebar">
                  <span data-l10n-id="toggle_sidebar_label">Toggle Sidebar</span>
                </button>
                <div class="toolbarButtonSpacer"></div>
                <button id="viewFind" class="toolbarButton group hiddenSmallView" title="Find in Document" tabindex="5" data-l10n-id="findbar">
                   <span data-l10n-id="findbar_label">Find</span>
                </button>
                <div class="splitToolbarButton">
                  <button class="toolbarButton pageUp" title="Previous Page" id="previous" tabindex="6" data-l10n-id="previous">
                    <span data-l10n-id="previous_label">Previous</span>
                  </button>
                  <div class="splitToolbarButtonSeparator"></div>
                  <button class="toolbarButton pageDown" title="Next Page" id="next" tabindex="7" data-l10n-id="next">
                    <span data-l10n-id="next_label">Next</span>
                  </button>
                </div>
                <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">Page: </label>
                <input type="number" id="pageNumber" class="toolbarField pageNumber" value="1" size="4" min="1" tabindex="8">
                </input>
                <span id="numPages" class="toolbarLabel"></span>
              </div>
              <div id="toolbarViewerRight">
                <input id="fileInput" class="fileInput" type="file" oncontextmenu="return false;" style="visibility: hidden; position: fixed; right: 0; top: 0" />

                <button id="presentationMode" class="toolbarButton presentationMode hiddenSmallView" title="Switch to Presentation Mode" tabindex="12" data-l10n-id="presentation_mode">
                  <span data-l10n-id="presentation_mode_label">Presentation Mode</span>
                </button>

                <button id="openFile" class="toolbarButton openFile hiddenSmallView" style="display:none" title="Open File" tabindex="13" data-l10n-id="open_file">
                   <span data-l10n-id="open_file_label">Open</span>
                </button>

                <button id="print" class="toolbarButton print" title="Print" style="display:none" tabindex="14" data-l10n-id="print">
                  <span data-l10n-id="print_label">Print</span>
                </button>

                <button id="download" class="toolbarButton download" style="display:none" title="Download" tabindex="15" data-l10n-id="download">
                  <span data-l10n-id="download_label">Download</span>
                </button>
                <!-- <div class="toolbarButtonSpacer"></div> -->
                <a href="#" id="viewBookmark" class="toolbarButton bookmark hiddenSmallView" style="display:none" title="Current view (copy or open in new window)" tabindex="16" data-l10n-id="bookmark"><span data-l10n-id="bookmark_label">Current View</span></a>
              </div>
              <div class="outerCenter">
                <div class="innerCenter" id="toolbarViewerMiddle">
                  <div class="splitToolbarButton">
                    <button id="zoomOut" class="toolbarButton zoomOut" title="Zoom Out" tabindex="9" data-l10n-id="zoom_out">
                      <span data-l10n-id="zoom_out_label">Zoom Out</span>
                    </button>
                    <div class="splitToolbarButtonSeparator"></div>
                    <button id="zoomIn" class="toolbarButton zoomIn" title="Zoom In" tabindex="10" data-l10n-id="zoom_in">
                      <span data-l10n-id="zoom_in_label">Zoom In</span>
                     </button>
                  </div>
                  <span id="scaleSelectContainer" class="dropdownToolbarButton">
                     <select id="scaleSelect" title="Zoom" oncontextmenu="return false;" tabindex="11" data-l10n-id="zoom">
                      <option id="pageAutoOption" value="auto" selected="selected" data-l10n-id="page_scale_auto">Automatic Zoom</option>
                      <option id="pageActualOption" value="page-actual" data-l10n-id="page_scale_actual">Actual Size</option>
                      <option id="pageFitOption" value="page-fit" data-l10n-id="page_scale_fit">Fit Page</option>
                      <option id="pageWidthOption" value="page-width" data-l10n-id="page_scale_width">Full Width</option>
                      <option id="customScaleOption" value="custom"></option>
                      <option value="0.5">50%</option>
                      <option value="0.75">75%</option>
                      <option value="1">100%</option>
                      <option value="1.25">125%</option>
                      <option value="1.5">150%</option>
                      <option value="2">200%</option>
                    </select>
                  </span>
                </div>
              </div>
            </div>
            <div id="loadingBar">
              <div class="progress">
                <div class="glimmer">
                </div>
              </div>
            </div>
          </div>
        </div>

        <menu type="context" id="viewerContextMenu">
          <menuitem id="firstPage" label="First Page"
                    data-l10n-id="first_page" ></menuitem>
          <menuitem id="lastPage" label="Last Page"
                    data-l10n-id="last_page" ></menuitem>
          <menuitem id="pageRotateCcw" label="Rotate Counter-Clockwise"
                    data-l10n-id="page_rotate_ccw" ></menuitem>
          <menuitem id="pageRotateCw" label="Rotate Clockwise"
                    data-l10n-id="page_rotate_cw" ></menuitem>
        </menu>

        <div id="viewerContainer">
          <div id="viewer" contextmenu="viewerContextMenu"></div>
        </div>

        <div id="errorWrapper" hidden="true">
          <div id="errorMessageLeft">
            <span id="errorMessage"></span>
            <button id="errorShowMore" onclick="" oncontextmenu="return false;" data-l10n-id="error_more_info">
              More Information
            </button>
            <button id="errorShowLess" onclick="" oncontextmenu="return false;" data-l10n-id="error_less_info" hidden="true">
              Less Information
            </button>
          </div>
          <div id="errorMessageRight">
            <button id="errorClose" oncontextmenu="return false;" data-l10n-id="error_close">
              Close
            </button>
          </div>
          <div class="clearBoth"></div>
          <textarea id="errorMoreInfo" hidden="true" readonly="readonly"></textarea>
        </div>
      </div> <!-- mainContainer -->

    </div> <!-- outerContainer -->
    <div id="printContainer"></div>
  </body>
</html>';

?>

