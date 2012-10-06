(function(){
	$('#dp1').datepicker();
	$('#monkeyform_modal').modal('show');
	Modal.prototype.hide = function() { return false; };
})();