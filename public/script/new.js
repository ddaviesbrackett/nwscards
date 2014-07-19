$(function(){
	$('input:radio[name="indiv-class"]').on('click', function(ev){
		$('.form-group.individual-classes').fadeToggle(400);
	});
});