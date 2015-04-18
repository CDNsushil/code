var Imtech = {};
Imtech.Pager = function() {
    this.paragraphsPerPage = 3;
    this.currentPage = 1;
    this.pagingControlsContainer = "#pagingControls";
    this.pagingContainerPath = "#pagingContent";
    this.numPages = function() {
        var numPages = 0;
        if (this.paragraphs != null && this.paragraphsPerPage != null) {
            numPages = Math.ceil(this.paragraphs.length / this.paragraphsPerPage);
        }
        return numPages;
    };
    	this.perPage = function(lst) {
			
			page = 1;
			this.paragraphsPerPage = lst;
			var html = "";
			for (var i = (page-1)*this.paragraphsPerPage; i < ((page-1)*this.paragraphsPerPage) + this.paragraphsPerPage; i++) {
				if (i < this.paragraphs.length) {
					var elem = this.paragraphs.get(i);
					html += "<" + elem.tagName + ">" + elem.innerHTML + "</" + elem.tagName + ">";
				}
			}
			$(this.pagingContainerPath).html(html);
			renderControls(this.pagingControlsContainer, this.currentPage, this.numPages());
			//renderMaxHeight();
	 }
    this.showPage = function(page) {
		
        this.currentPage = page;
        var html = "";
        for (var i = (page-1)*this.paragraphsPerPage; i < ((page-1)*this.paragraphsPerPage) + this.paragraphsPerPage; i++) {
            if (i < this.paragraphs.length) {
                var elem = this.paragraphs.get(i);
                html += "<" + elem.tagName + ">" + elem.innerHTML + "</" + elem.tagName + ">";
            }
        }
        $(this.pagingContainerPath).html(html);
        renderControls(this.pagingControlsContainer, this.currentPage, this.numPages());
       	//$('html, body').animate({scrollTop:0});
		//$('html, body').animate({scrollTop:'200px'}, 'fast');
		 
    }
    var renderControls = function(container, currentPage, numPages) {
		if($("img.lazy")){
			$("img.lazy").lazyload();
	    }
	   
		var perPage = $("#myselect").val();
        var pagingControls = "";
	   	var counter = 1;
		var pageLimit = 3;
			counter = (currentPage/3 * 3) ? (currentPage/3 * 3):1;
			pageLimit =counter+3;	
			pageLimit =	counter > 2?(counter+2):(counter>1)?(counter+3):(counter+2);
			counter =	counter > 2?(counter-2):(counter>1)?(counter-1):counter;
		if(currentPage >1 ){
				 pagingControls += "<div class='btn_prev_wrapper'><a href='#' onclick='pager.perPage(" + perPage + "); pager.showPage(" + (parseInt(currentPage)-1) + "); return false;'><span class='btn_prev'>Prev</span></a></div>";
			}
			else if(currentPage == 1 ){
			pagingControls += "<div class='btn_prev_wrapper'><span class='btn_prev disable_btn'>Prev</span></div>";	
				
				}	
			pagingControls += "<div class='pagination_mid'>";
	    for (var i = counter; i <= pageLimit && i <=numPages ; i++) {
		    if (i != currentPage) {
                pagingControls += " <div class='Page_cont '><a href='#' onclick='pager.perPage(" + perPage + ");pager.showPage(" + i + "); return false;'>" + i + "</a></div>";
            } else {
                pagingControls += "<div class='cont_sel Page_cont'>" + i + "</div>";
            }
        }
        	pagingControls += "</div>";
        	
		if(currentPage < numPages ){
				 pagingControls += "<div class=' btn_next_wrapper'><a href='#' onclick='pager.perPage(" + perPage + ");pager.showPage(" + (parseInt(currentPage)+1) + "); return false;'><div class='btn_next'> Next </div></a></div>";
			}
			else if(currentPage == numPages)
			{
				pagingControls += "<div class=' btn_next_wrapper'><div class='btn_next disable_btn'>Next</div></div>";
				
				}
		
        pagingControls += "";
        $(container).html(pagingControls);
        runTimeCheckBox();
        
    }
}
