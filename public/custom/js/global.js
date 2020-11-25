$(document).ready(function(){
	$(".custom-dropdown-toggle").click(function(){
		$(".custom-dropdown-menu").toggle();
	});
	$(window).click(function() {
		$(".custom-dropdown-menu").hide();
	});

	$(".item-rating").starRating({
	    totalStars: 5,
	    emptyColor: 'lightgray',
	    hoverColor: '#efc501',
	    activeColor: '#efc501',
	    strokeWidth: 0,
	    useGradient: false,
	    readOnly: true,
	    starSize: 15,
	});

	$(".item-rating-20").starRating({
	    totalStars: 5,
	    emptyColor: 'lightgray',
	    hoverColor: '#efc501',
	    activeColor: '#efc501',
	    strokeWidth: 0,
	    useGradient: false,
	    readOnly: true,
	    starSize: 20,
	});
});