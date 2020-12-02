var product = new product();

function product()
{
	init();
	var loader = '<div class="mtb-3m"><center><div class="spinner-border text-warning spinnger-7" role="status"> <span class="sr-only">Loading...</span></div> </center></div>';

	function init()
	{
		inputmovements();
		formsubmit();
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
			$(".cart-qty").val(1);
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

		$(".btn-wish").unbind("click");
		$(".btn-wish").bind("click", function(e){
			e.preventDefault();
			var href = $(this).attr('href');
			var ref = $(this).data('ref');
			$.ajax({
				url 	: 	href,
				type 	: 	'POST',
				data 	: 	{
					'ref' : ref
				},
				success : function(result)
				{

				},
				error 	: function(err)
				{
					console.log(err);
				}
			});
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

	function formsubmit()
	{
		$(".btn-cart").unbind("click");
		$(".btn-cart").bind("click", function(e){
			var uri = $(this).data('url');
			var role = $(this).data('role');
			$(".form-cart").attr('action',uri);
			if(role == 'checkout')
			{
				$(".form-cart").unbind("submit");
				$(".form-cart").submit();
			}
			$(".cart-content").html(loader);
			var formdata = $(".form-cart").serialize();
			$.ajax({
				url : uri,
				type : 'POST',
				data : formdata,
				success : function(result)
				{
					$(".cart-content").html(result.html);
					$(".cart-main-qty").html(result.cart_qty);
					if(result.cart_qty > 0)
					{
						$(".cart-main-qty").removeClass('hide');
					}
					else
					{
						$(".cart-main-qty").addClass('hide');
					}
				},
				error 	: function(err)
				{

					if(err.responseJSON.message != 'Unauthenticated.')
					{
						var message = 'Server Error, please try again.';
						var json = JSON.parse(err.responseText);
						if(json.error !== undefined)
						{
							message = json.error;
						}
						var html = '<div class="text-center mtb-3m"><h3 class="color-red">'+message+'</h3></div>';
						$(".cart-content").html(modal_error(message));
					}
					else
					{
						console.log("err", err);
						modal_login($(".cart-content"));
					}
				}
			});
			
		});

		$(".form-cart").unbind("submit");
		$(".form-cart").bind("submit", function(e){
			e.preventDefault();
		});
	}

	function modal_login(target)
	{
		var uri = $('meta[name="modal-login"]').attr('content');
		$.ajax({
			url : uri,
			type : 'POST',
			data : {},
			success : function(result)
			{
				target.html(result);
				form_login();
			},
			error : function(err)
			{
				var html = '<div class="text-center mtb-3m"><h3 class="color-red">Server Error, please try again.</h3></div>';
				target.html(html);
			}
		});
	}

	function modal_error(message)
	{
		var html = '<div class="modal-header">' +
				    '<a href="#" class="close" data-dismiss="modal" aria-hidden="true">×</a>' +
				'</div>' + 
				'<div class="modal-body">' +
				    '<div class="row">' +
				        '<div class="col-md-12 text-center mtb-3m">' +
				            '<h4 class="color-red">'+message+'</h4>' +
				        '</div>' +
				    '</div>' +
				'</div>';
		return html;
	}

	function form_login()
	{
		$(".form-login").unbind("submit");
		$(".form-login").bind("submit", function(e){
			var uri = $(this).attr('action');
			var method = $(this).attr('method');
			var formdata = $(this).serialize();
			$.ajax({
				url 	: 	uri,
				type  	: 	method,
				data 	: 	formdata,
				success : function(result)
				{
					window.location.reload();
				},
				error 	: 	function(err)
				{

				}
			});
		});
	}
}