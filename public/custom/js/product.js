var product = new product();

function product()
{
	init();

	function init()
	{
		inputmovements()
	}

	function inputmovements()
	{
		$(".variant-change").unbind("change");
		$(".variant-change").bind("change", function(){
			var price = parseFloat($(this).data('price'));
			var pricestr = $(this).data('pricestr');
			var stock = parseFloat($(this).data('stock'));
			var stockstr = $(this).data('stockstr');

			$(".span-price").html(pricestr);
			$(".stock-remaining").html(stockstr);
			$(".cart-qty").attr('max', stock);
			$(".cart-qty").val(0);
		});

		$(".btn-minus").unbind("click");
		$(".btn-minus").bind("click", function(){
			var current = parseFloat($(".cart-qty").val());
			current--;
			if(current <= 1)
			{
				current = 1;
			}
			$(".cart-qty").val(current);
		});

		$(".btn-plus").unbind("click");
		$(".btn-plus").bind("click", function(){
			var current = parseFloat(null2zero($(".cart-qty").val()));
			current++;
			var max = parseFloat($(".cart-qty").attr('max'));
			if(current > max)
			{
				current = max;
			}
			$(".cart-qty").val(current);
		});
	}

	function null2zero(value)
	{
		if(value == null || value == '')
		{
			value = 0;
		}
		return value;

	}
}