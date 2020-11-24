$(document).ready(function(){
	$(".custom-dropdown-toggle").click(function(){
		$(".custom-dropdown-menu").toggle();
	});
	$(window).click(function() {
		$(".custom-dropdown-menu").hide();
	});

	

});
$(function() {
	$(".item-rating").starRating({
	    totalStars: 5,
	    emptyColor: 'lightgray',
	    hoverColor: '#efc501',
	    activeColor: '#efc501',
	    strokeWidth: 0,
	    useGradient: false,
	    readOnly: true
	});
});