$(function(){
	$('input:radio[name="indiv-class"]').on('click', function(ev){
		var $classes = $('.form-group.individual-classes');
		if(this.id == 'indiv-class-classes') {
			$classes.fadeIn(400);
		}
		else {
			$classes.fadeOut(400);
			$classes.find('input[type="checkbox"]').attr('checked',false);
		}
	});

	$('input:radio[name="payment"]').on('click', function(ev){
		var val = this.value;
		$('.payment.'+val).fadeIn(400);
		$('.payment:not(.'+val+')').hide();
	}).each(function(){
		var val = this.value;
		$('.payment.' + val).toggle(this.checked);
	});

	$('form.new-order').submit(function(ev){
		if($('#indiv-class-classes').is(":checked")) {
			if(!$('.individual-classes input[type="checkbox"]:checked').length) {
				if(confirm('You said you wanted to support individual classes, but didn\'t select any. '+
					'Click OK to support the whole school, or Cancel to select some classes to support.')) {
					return true;
				}
				else {
					$('.individual-classes input[type="checkbox"]').eq(0).focus();
					return false;
				}
			}
		}
	})
	var $form = $('form.new-order');

	var stripeResponseHandler = function(status, response)
	{
		if(response.error)
		{
			$form.find('.payment-errors').text(response.error.message);
			$form.find('.payment-errors-group').show();
    		$form.find('button').prop('disabled', false);
		}
		else
		{
			// response contains id and card, which contains additional card details
			var token = response.id;
			// Insert the token into the form so it gets submitted to the server
			$form.append($('<input type="hidden" name="stripeToken" />').val(token));
			// and submit
			$form.get(0).submit();
		}
	};

	$form.submit(function(ev) {
		// Disable the submit button to prevent repeated clicks
		$form.find('button').prop('disabled', true);
		if($('#payment_credit').is(':checked')) {

			Stripe.card.createToken($form, stripeResponseHandler);

			// Prevent the form from submitting with the default action
			return false;
		}
	});
});