// JavaScript Document
//Call at the time of upload

function upload(fileObj,url){


    var par = window.document;

    var frm = fileObj;

    var div_id = parseInt(Math.random() * 100000);



   // add image progress

    var images = par.getElementById('images_container');

    //images.innerHTML = '';

    var new_div = par.createElement('div');

    new_div.id = div_id;

    // send

    frm.div_id.value = div_id;


}

//Call when upload completed

function setUploadedImage(imgName,imgSrc,imgWidth,imgHeight) {
  var sel, range, html, str;
    var par = window.document;

    var images = par.getElementById('images_container');

    var new_div = par.createElement('div');
			 
	new_div.setAttribute("class", 'img');

    //    new_div.id = div_id;

    var new_img = par.createElement('img');
				
	new_img.setAttribute("class", 'galleryImg');

   // new_img.setAttribute("width", imgWidth);

    //new_img.setAttribute("height",imgHeight);
	
	//new_img.setAttribute("onload", 'insertNodeOverSelection(this, document.getElementById(\'myInstance1\'));');
	
    new_img.src = '../photos/indicator2.gif';

    new_div.appendChild(new_img);

    images.appendChild(new_div);
		
    new_img.src = imgSrc;

	$('#new_div').append(new_img.src);

	$('#myInstance1').append(new_img);
	$('#postViewGalleryBoxWp').trigger('close');

}