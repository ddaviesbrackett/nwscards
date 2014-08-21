$(function(){
	var $cf = $('form.contact');
	var $nm = $cf.find('input.nm');
	var $em = $cf.find('input.em');
	var $msg = $cf.find('textarea.msg');
	var $err = $cf.find('.error');
	var $success = $cf.find('.success');
	$cf.submit(function(ev){
		var errors = [];
		function showErrors(content) {
			$err.find('.content').html(content);
			$err.removeClass('hidden');
		}
		function showSuccess(content) {
			$success.find('.content').html(content);
			$success.removeClass('hidden');
		}
		if(!$nm.val()){
			errors.push('Please enter your name.');
		}
		if(!$em.val()){
			errors.push('email address can\'t be empty.');
		}
		if(!$msg.val()){
			errors.push('Message can\'t be empty.');
		}
		if(errors.length) {
			showErrors(errors.join('<br/>'));
		}
		else
		{
			$err.addClass('hidden');
			$success.addClass('hidden');
		
			$.post('/contact', $cf.serializeArray(), function(data){
				if(!data.r || !data.r.status == 'success')
				{
					showErrors('Whoops. There was an error contacting us.');
				}
				else
				{
					showSuccess('Message sent. You\'ll hear from us soon!');
					$nm.val('');
					$em.val('');
					$msg.val('');
				}
			});
		}
		ev.preventDefault();
		return false;
	})
});