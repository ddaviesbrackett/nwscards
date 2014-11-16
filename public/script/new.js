$(function(){

	if ($('.individual-classes').find('input[type="checkbox"]:checked').length > 0)
	{
		$('#indiv-class-classes').attr('checked', true);
	}
	else
	{
		$('#indiv-class-school').attr('checked', true);
	}

	function fadeClassCheck(ev){
		if(this.checked) {
			var $classes = $('.individual-classes');
			if(this.id == 'indiv-class-classes') {
				$classes.fadeIn(400);
			}
			else {
				$classes.fadeOut(400);
				$classes.find('input[type="checkbox"]').attr('checked',false);
			}
		}
	}

	$('input:radio[name="indiv-class"]').on('click', fadeClassCheck ).each(fadeClassCheck);
	
	function radioSection(radioname){
		$('input:radio[name="'+radioname+'"]').on('click', function(ev){
			var val = this.value;
			$('.'+radioname+'.'+val).fadeIn(400);
			$('.'+radioname+':not(.'+val+')').hide();
		}).each(function(){
			var val = this.value;
			$('.'+radioname+'.' + val).toggle(this.checked);
		});
	}
	radioSection('payment');
	radioSection('deliverymethod');
	radioSection('schedule');
	
	$errorBox = $('.blackoutPeriodError');
	$(".blackoutPeriod.callout").addClass("disabled").prepend($errorBox)
	.on('click', function()
	{
		alert("You cannot edit this during blackout period.");
	}).find(':input').attr("disabled", true).addClass('disabled');

	function positionBlackoutErrorBox()
	{
		$(".blackoutPeriod.callout").each(function()
		{
			$varParent = $(this);
			$varParent.find('.blackoutPeriodError')
				.width($varParent.outerWidth())
				.height($varParent.outerHeight())
				.show()
				.css({
					left: $varParent.position().left + "px",
					top: $varParent.position().top + "px",
				});
		});
	}

	$(window).load(positionBlackoutErrorBox).on('resize', positionBlackoutErrorBox);

	$('.order input[type="number"]').on('blur', function(ev){
		var $this = $(this);
		var val = parseInt($this.val(), 10);
		$this.closest('.form-group').find('.alert').toggleClass('hidden', !val || val < 10).find('.amt').text(val);
	});

	var $form = $('form.new-order');
	$form.submit(function(ev){
		if($('#indiv-class-classes').is(":checked")) {
			if(!$('.individual-classes input[type="checkbox"]:checked').length) {
				if(confirm('You said you wanted to support individual classes, but didn\'t select any. '+
					'Click OK to support the whole school, or Cancel to select some classes to support.')) {
					return true;
				}
				else {
					$('.individual-classes input[type="checkbox"]').eq(0).focus();
					$form.find('button').prop('disabled', false);
					return false;
				}
			}
		}
	})

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

		// re-enable form elements so validation doesn't fail.
		$form.find('.blackoutPeriod :input').attr('disabled', false);

		if($('#payment_credit').is(':checked')) {

			Stripe.card.createToken($form, stripeResponseHandler);

			// Prevent the form from submitting with the default action
			return false;
		}
	});
});