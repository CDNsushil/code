/**
 * @description: Loader show plugin 
 */ 

(function ( $ ) {
  
  $.fn.loaderShow = function() {
    this.css( "display", "block" );
    return this;
  }
  
  $.fn.loaderHide = function() {
    this.css( "display", "none" );
    return this;
  }

}( jQuery ));


