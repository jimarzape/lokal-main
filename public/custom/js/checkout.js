var checkout = new checkout();
function checkout()
{
	init();

	function init()
	{
		btn_function()
	}

	function btn_function()
	{
		$(".checkout-tab-button").unbind("click");
		$(".checkout-tab-button").bind("click", function(){
			var target = $(this).data('target');
			$(".checkout-tab").addClass('hide');
			$(target).removeClass('hide');
			$(".checkout-tab-button").find('.checkout-default').removeClass('active');
			$(this).find('.checkout-default').addClass('active');
		});

		$(".btn-toggle-tab").unbind("click");
		$(".btn-toggle-tab").bind("click", function(){
			var target = $(this).data('target');
			$(".checkout-tab-button").each(function(){
				if($(this).data('target') == target)
				{
					$(this).click();
				}
			});
		});

		$(".courier-radio").unbind("change");
		$(".courier-radio").bind("change", function(){
			console.log('change');
			$(".courier-radio").parent(".courier-option").removeClass('active');
			$(this).parent(".courier-option").addClass('active');
		});
	}
}