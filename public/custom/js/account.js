var account = new account();

function account()
{
	init();

	function init()
	{
		btn_function();
		select_ajax();
	}

	function btn_function()
	{
		$(".show-form").unbind("click");
		$(".show-form").bind("click", function(){
			$(".info-display").addClass('hide');
			$(".input-form").removeClass('hide');
		});

		$(".hide-form").unbind("click");
		$(".hide-form").bind("click", function(){
			$(".info-display").removeClass('hide');
			$(".input-form").addClass('hide');
		});
	}

	function select_ajax()
	{
		$(".address-select").unbind("change");
		$(".address-select").bind("change", function(e){
			var code = $(this).find(":selected").data('value');
			var target = $(this).data('target');
			var uri = $(this).data('url');
			$(target).html("<option>loading...</option>");
			$.ajax({
				url 	: uri,
				type 	: 'POST',
				data 	: {
					"code" : code
				},
				success : function(result)
				{
					var html = '';
					$.each(result, function(index, data){
						html += '<option value="'+data.name+'" data-value="'+data.code+'">'+data.name+'</option>';
					})
					$(target).html(html);
					select_ajax();
				},
				error 	: 	function(err)
				{
					alert('Error, something went wrong');
					console.log(err);
					$(target).html("<option>Error</option>");
					select_ajax();
				}
			});
		});
	}
}