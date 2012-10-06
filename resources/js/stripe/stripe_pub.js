// This identifies your website in the createToken call below
// TEST KEY. SWITCH OUT FOR LIVE CARDS
Stripe.setPublishableKey('pk_INtFuI8IVixojF6B3LCDgDPhBR5fG');

$(document).ready(function(){
	$("#payment-form").submit(function(event){
		$('.submit-button').attr("disabled", "disabled");
		
		Stripe.createToken({
			number: $('.card-number').val(),
			cvc: $('.card-cvc').val(),
			exp_month: $('.card-expiry-month').val(),
			exp_year: $('.card-expiry-year').val()
		}, stripeResponseHandler);
		
		return false;
	});
});

function stripeResponseHandler(status, response){
	if (response.error) {
		// show the errors on the form
		$(".payment-errors").text(response.error.message);
		$(".submit-button").removeAttr("disabled");
	} else {
		var form$ = $("#payment-form");
		// token contains id, last4, and card type
		var token = response['id'];
		// insert the token into the form so it gets submitted to the server
		form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
		form$.get(0).submit();
	}
}