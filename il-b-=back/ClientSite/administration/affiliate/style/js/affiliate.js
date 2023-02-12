jQuery(function($){
	$(document).ready(function(){
		$(".form-validate").validate();
		$('.datepicker-input').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true
		});
	});
});