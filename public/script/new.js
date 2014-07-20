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
		$('.row.payment.'+val).fadeIn(400);
		$('.row.payment:not(.'+val+')').hide();
	});

	$('form.new-order').submit(function(ev){
		if($('#indiv-class-classes').is(":checked")) {
			if(!$('.individual-classes input[type="checkbox"]:checked').length) {
				if(confirm('You said you wanted to support individual classes, but didn\'t select any.  Click OK to support the whole school, or Cancel to select some classes to support.')) {
					return true;
				}
				else {
					$('.individual-classes input[type="checkbox"]').eq(0).focus();
					return false;
				}
			}
		}
	})
});