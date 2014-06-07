/* Author: 

*/

$(document).ready(function(){

			$('#slider').nivoSlider({
			    effect: 'boxRain',               // Specify sets like: 'fold,fade,sliceDown'
			    slices: 15,                     // For slice animations
			    boxCols: 8,                     // For box animations
			    boxRows: 4,                     // For box animations
			    animSpeed: 1200,                 // Slide transition speed
			    pauseTime: 5000,                // How long each slide will show
			    startSlide: 0,                  // Set starting Slide (0 index)
			    directionNav: false,             // Next & Prev navigation
			    controlNav: true,               // 1,2,3... navigation
			    controlNavThumbs: false,        // Use thumbnails for Control Nav
			    pauseOnHover: true             // Stop animation while hovering
			});
	
	$("[rel^='prettyPhoto']").prettyPhoto();
});



















