$(document).ready(function(){
	$(".custom-dropdown-toggle").click(function(){
		$(".custom-dropdown-menu").toggle();
	});
	$(window).click(function() {
		$(".custom-dropdown-menu").hide();
	});
});