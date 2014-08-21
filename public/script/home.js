$(function(){
	var $cf = $('form.contact');
	var $nm = $cf.find('input.nm');
	var $em = $cf.find('input.em');
	var $msg = $cf.find('textarea.msg');
	$cf.submit(function(ev){
		//validation here
		$.post('/contact', $cf.serializeArray(), function(data){
			if(!data.r || !data.r.status == 'success')
			{
				alert('Whoops.  there was an error contacting us.  Send us an email, please.');
			}
			else
			{
				alert('message sent.  you\'ll hear from us soon!');
				$nm.val('');
				$em.val('');
				$msg.val('');
			}
		});
		ev.preventDefault();
		return false;
	})
});