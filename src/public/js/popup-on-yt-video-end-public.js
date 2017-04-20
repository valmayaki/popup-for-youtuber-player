(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


//	var tag = document.createElement('script');
//
//	tag.src = "https://www.youtube.com/iframe_api";
//	var firstScriptTag = document.getElementsByTagName('script')[0];
//	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	
})( jQuery );

var player;
function onYouTubeIframeAPIReady() {
    // first video
    
    var PlayerOptions = {
    	
        events: {
            'onReady': function(){ console.log("Ready!"); },
            'onStateChange': onPlayerStateChange
        }
    };

    if("undefined" !== typeof PopupYT.videoId ){
    	PlayerOptions.videoId = PopupYT.videoId;
    }

    player = new YT.Player(jQuery(PopupYT.selector)[0], PlayerOptions);
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED) {
    	jQuery("#activator-"+PopupYT.selector).click();
        console.log('player stopped');
    }
}
