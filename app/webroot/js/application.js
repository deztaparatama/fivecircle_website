$(
	function()
	{
		$('#datepicker').datepicker({dateFormat:'dd MM yy'});

		$('.placeThumbnail img').click(function(){ // faire plutôt des animate...
			if($(this).css('height') == '100px')
				$(this).css('height', 'inherit');
			else
				$(this).css('height', '100px');
		});
	}
);