var cart = new cart();

function cart()
{
	init();

	function init()
	{
		btn_function();
	}

	function btn_function()
	{
		$(".btn-minus").unbind("click");
		$(".btn-minus").bind("click", function(){
			var parent = $(this).parents('.cart-quantity');
			var target = parent.find('.cart-qty');
			var current = parseFloat(target.val());
			var previous = current;
			var ref 	= parent.data('ref');
			current--;
			if(current <= 1)
			{
				current = 1;
			}
			target.val(current);
			compute_due();
			if(previous != current)
			{
				update_cart(ref, current);
			}
			
		});

		$(".btn-plus").unbind("click");
		$(".btn-plus").bind("click", function(){
			var parent = $(this).parents('.cart-quantity');
			var target = parent.find('.cart-qty');
			var current = parseFloat(null2zero(target.val()));
			var previous = current;
			current++;
			var max = parseFloat(parent.data('max'));
			var ref 	= parent.data('ref');
			if(current > max)
			{
				current = max;
			}
			target.val(current);
			compute_due();
			if(previous != current)
			{
				update_cart(ref, current);
			}
		});

		$(".remove-item").unbind("click");
		$(".remove-item").bind("click", function(){
			var element 	= $(this);
			var html 		= element.html();
			element.html('removing...');
			var ref 		= element.data('ref');
			var parent 		= element.parents('.cart-item-container');
			var error 	 	= parent.find('.error-message');
			var link 		= $('meta[name="remove-cart"]').attr('content');
			error.html('');
			$.ajax({
				url : link,
				type : 'POST',
				data : {
					'ref' : ref
				},
				success : function(err)
				{
					parent.remove();
					compute_due();
					check_child();
				},
				error   : function(err)
				{
					element.html(html);
					error.html('Error, please try again.');
				}
			});
		});
	}

	function check_child()
	{
		$(".cart-container").each(function(){
			var child = $(this).find('.cart-item-container');
			if(child.length <= 0)
			{
				$(this).remove();
			}
		});
	}

	function update_cart(ref, qty)
	{
		var link = $('meta[name="update-cart"]').attr('content');
		$.ajax({
			url 	: 	link,
			type 	: 	'POST',
			data 	: 	{
				'ref' : ref,
				'qty' : qty
			},
			success : function(result)
			{
				console.log(result);
			},
			error 	: function(err)
			{
				console.log(err);
			}
		});
	}

	function compute_due()
	{
		var amountdue = 0;
		var total_qty = 0;
		$(".cart-quantity").each(function(){
			var price = parseFloat($(this).data('price'));
			var qty = parseFloat($(this).find('.cart-qty').val());
			total_qty += qty;
			amountdue += (qty * price);
		});
		$(".total-qty").html(total_qty);
		$(".summary-subs").html(money(amountdue));
	}

	function null2zero(value)
	{
		if(value == null || value == '')
		{
			value = 0;
		}
		return value;

	}

	function  money(val) {
		val = parseFloat(val);
		val = val.toFixed(2);
		return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
}