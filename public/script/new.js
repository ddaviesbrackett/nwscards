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
});