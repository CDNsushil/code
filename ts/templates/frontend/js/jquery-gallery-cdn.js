// JavaScript Document

	// TO HOLD THE PREVIOUS IMAGE INDEX
	var prevImageIndex = null;
	
	// TO HOLD CURRENT IMAGE INDEX
	var currentImageIndex = 0;
	
	// TO HOLD CURRENT IMAGE SOURCE
	var currentImageSrc = '';
	
	// TO HOLD IMAGE DESCRIPTION
	var currentImageDescription = '';
	
	// TO HOLD TOTAL GALLERY IMAGES
	var totalImage = 0;
	
	// CREATE LIST ARRAY
	var optionTexts = [];
	
	// TO HOLD AUTOPLAY INSTRUCTIONS
	var autoPlay = false;
	
	// TO HOLD PAUSE DURATION INCASE OF AUTOPLAY (3 sec = 3000)
	var delay = 3000;
	
	var timer;

	var viewerType = '';
	// DIV DEFINITIONS.
	/*var imageListUL = '#imageList';
	var imageHolderDIV = '#imageHolder';
	var imageDiv = "#imageDiv"
	var imageDescriptionDiv = '#imageDescription';
	var imageActiveCSS = 'imgActiveBorder';
	var imageLoader = "#loaderDiv";*/
	
	var imageListUL = '';
	var imageHolderDIV = '';
	var imageDiv = '';
	var imageDescriptionDiv = '';
	var imageActiveCSS = '';
	var imageLoader = '';
	var borderAreaDivClass = '';
	var callBackMethod;	
	
	//alert( $("#imageList").children([0]).children([0]).attr('src'))	
	//alert( $(optionTexts[0]).children([0]).attr('src') )
	//alert($(optionTexts).length);
	//alert($("#imageHolder img").attr('src', currentImageSrc))
	
	function initialise(){
		
		imageListUL = $.gallery.options._imageListUL;
		imageHolderDIV = $.gallery.options._imageHolderDIV;
		imageDiv = $.gallery.options._imageDiv;
		imageDescriptionDiv = $.gallery.options._imageDescriptionDiv;
		imageActiveCSS = $.gallery.options._imageActiveCSS;
		imageLoader = $.gallery.options._imageLoader;
		autoPlay = $.gallery.options._autoPlay;
		delay = $.gallery.options._delay;
		borderAreaDivClass  = $.gallery.options._borderAreaDivClass;
		callBackMethod = $.gallery.options._callBackMethod;
		viewerType  = $.gallery.options._viewerType;
		
		if($.gallery.options._currentImageIndex != undefined)
		currentImageIndex = $.gallery.options._currentImageIndex;

		$(imageListUL+" li").each(function() {optionTexts.push($(this)) });
		
		totalImage = $(optionTexts).length;
		
		loadViewer();
	}
	
	function loadViewer(){
		
		if(viewerType == "video")
			{
				loadVideo();
			}else {
				loadImage();
			}
	}
	
	// LOAD IMAGE BASED ON IMAGE INDEX
	function loadVideo(){
		//alert( "perminder");
		
		currentImageSrc = $(optionTexts[currentImageIndex]).attr('targetpath');
		currentHref = $(optionTexts[currentImageIndex]).attr('href');
		
		currentImageDescription = '';
		if($(optionTexts[currentImageIndex]).children()[1] != undefined ){
		 	currentImageDescription = $(optionTexts[currentImageIndex]).children()[1].innerHTML
		}
		
		$(imageLoader).show();
		$(imageDiv+" iframe").attr('src', currentImageSrc);
		$(imageDiv+" a").attr('href', currentHref);
		$(imageDiv).hide();
		
		$(imageDiv+" iframe")
			.load(function() {
				$('#messageDiv').hide();
				
				$(imageDiv).fadeIn("fast");
				$(imageLoader).hide()
			})
			.error(function(){
				$(imageDiv).hide();
				$('#messageDiv').show();
				$('#messageDiv').text('Image is not loaded!');
			});
		
		
		$(imageDescriptionDiv).html(currentImageDescription);
		
		// REMOVE CSS FROM PREVIOUS LIST ITEM
		if(prevImageIndex != null) $(optionTexts[prevImageIndex]).find(borderAreaDivClass).removeClass( imageActiveCSS );
		//$(optionTexts[prevImageIndex]).children([0]).removeClass( imageActiveCSS )
		
		// ADD CSS TO CURRENT LIST ITEM
		$(optionTexts[currentImageIndex]).find(borderAreaDivClass).addClass( imageActiveCSS )
		//$(optionTexts[currentImageIndex]).children([0]).addClass( imageActiveCSS )
		
		if(callBackMethod != null) callBackMethod(this);
		
		// UPDATING PREVIOUS IMAGE INDEX
		prevImageIndex = currentImageIndex;
		
		if(autoPlay == true){
			clearTimeout(timer);
			
			timer = setTimeout( nextImage, delay);
			
			/*timer = setTimeout(function(){
			  nextImage();
			}, delay);*/
		}

	}
	
	
	
	// TRIGGER NEXT IMAGE
	//old code for portfolio gallery
	/*function nextImage(){
		currentImageIndex ++;
		if(currentImageIndex > (totalImage-1)){
			currentImageIndex = 0;
		}
		
		loadViewer();
	}
	
	// TRIGGER PREVIOUS IMAGE
	function prevImage(){
		currentImageIndex --;

		if(currentImageIndex < 0){
			currentImageIndex = (totalImage-1);
		}
		
		loadViewer();
	}*/
	
	// TRIGGER NEXT IMAGE
	function nextImage(){
		
		//alert(currentImageIndex);
		if(currentImageIndex < (totalImage-1)){
			
			$("#prevImageButton").removeClass();
			$("#prevImageButton").addClass('gall_pre_btn_profile Fleft');
			
			currentImageIndex ++;
			//sets input hidden value for current selected image from the popup of images to get showen in full screnn gallery as start image
			$('#fullScreenCurrentImage').val(currentImageIndex);
		
			//currentImageIndex = 0;
			loadViewer();
			if(currentImageIndex==(totalImage-1))
			{
				$("#nextImageButton").removeClass();
				$("#nextImageButton").addClass('gall_next_btn_profile Fright disable');
				//$("#nextImageButton").removeClass();
			}	
		}
		
	}
	
	// TRIGGER PREVIOUS IMAGE
	function prevImage(){
		
		
		//alert(currentImageIndex);
		if(currentImageIndex > 0){
			currentImageIndex --;
			
			//sets input hidden value for current selected image from the popup of images to get showen in full screnn gallery as start image
			$('#fullScreenCurrentImage').val(currentImageIndex);
		
			//currentImageIndex = (totalImage-1);
			loadViewer()
			$("#nextImageButton").removeClass();
			$("#nextImageButton").addClass('gall_next_btn_profile Fright');
			if(currentImageIndex==0)
			{
				$("#prevImageButton").removeClass();
				$("#prevImageButton").addClass('gall_pre_btn_profile Fleft disable');
			}
		}else
		{
			
			$("#prevImageButton").removeClass();
			$("#prevImageButton").addClass('gall_pre_btn_profile Fleft disable');
		}
		
		
	}
	
	// TRIGGER ON LIST ITEM
	function loadMe(listItem){
		
		currentImageIndex = $(imageListUL+" li").index(listItem) 
		//sets input hidden value for current selected image from the popup of images to get showen in full screnn gallery as start image
		$('#fullScreenCurrentImage').val(currentImageIndex);
		
		
		loadViewer();
		
	}
	
	// LOAD IMAGE BASED ON IMAGE INDEX
	function loadImage(){
		// $(optionTexts[currentImageIndex]).children()[1].innerHTML 
		//alert($(imageLoader));
		currentImageSrc = $(optionTexts[currentImageIndex]).attr('originalImage');
		currentHref = $(optionTexts[currentImageIndex]).attr('href');
		
		currentImageDescription = '';
		if($(optionTexts[currentImageIndex]).children()[1] != undefined ){
		 	currentImageDescription = $(optionTexts[currentImageIndex]).children()[1].innerHTML
		}
		
		$(imageLoader).show();
		$(imageDiv+" img").attr('src', currentImageSrc)
		$(imageDiv+" a").attr('href', currentHref)
		$(imageDiv).hide();
		
		$(imageDiv+" img")
			.load(function() {
				//alert('I m here to load');
				$('#messageDiv').hide();
				
				$(imageDiv).show("fast");
				$(imageDiv).fadeIn("fast");
				$(imageLoader).hide()
			})
			.error(function(){
				$(imageDiv).hide();
				$('#messageDiv').show();
				$('#loaderDiv').hide();
				//$('#messageDiv').text(' No Media Found!');
			});
		
		
		$(imageDescriptionDiv).html(currentImageDescription);
		
		// REMOVE CSS FROM PREVIOUS LIST ITEM
		if(prevImageIndex != null) $(optionTexts[prevImageIndex]).find(borderAreaDivClass).removeClass( imageActiveCSS );
		//$(optionTexts[prevImageIndex]).children([0]).removeClass( imageActiveCSS )
		
		// ADD CSS TO CURRENT LIST ITEM
		$(optionTexts[currentImageIndex]).find(borderAreaDivClass).addClass( imageActiveCSS )
		//$(optionTexts[currentImageIndex]).children([0]).addClass( imageActiveCSS )
		
		if(callBackMethod != null) callBackMethod(this);
		
		// UPDATING PREVIOUS IMAGE INDEX
		prevImageIndex = currentImageIndex;
		
		//sets input hidden value for current selected image from the popup of images to get showen in full screnn gallery as start image
		$('#fullScreenCurrentImage').val(currentImageIndex);
		
		if(autoPlay == true){
			clearTimeout(timer);
			
			timer = setTimeout( nextImage, delay);
			
			/*timer = setTimeout(function(){
			  nextImage();
			}, delay);*/
		}

	}
	
	
	// TRIGGER FROM LARGE IMAGE.
	function bigImageEvent(){
		alert("me")
	}
