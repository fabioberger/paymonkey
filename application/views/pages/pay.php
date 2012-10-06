<div class="container">
	<div class="hero-unit">
		<div class="row">
				<div class="span9">
					<h1>
						Pay your share now!
					</h1>
				</div>
		</div>
	</div>
	<div class="row top-bottom-space-sm">
		<div class="payment-errors">
		</div>
	</div>
	<div class="row top-bottom-space-sm">
		<div class="span9">
			<form action="" method="POST" id="payment-form">
				<div class="form-row">
					<label>Card Number</label>
					<input type="text" size="20" autocomplete="off" class="card-number"/>				
				</div>
				<div class="form-row">
					<label>CVC</label>
					<input type="text" size="4" autocomplete="off" class="card-cvc"/>				
				</div>
				<div class="form-row">
					<label>Expiration (MM/YYYY)</label>
					<input type="text" size="2" class="card-expiry-month"/>				
					<span>/</span>
					<input type="text" size="4" class="card-expiry-year"/>				
				</div>
				<button type="submit" class="submit-button">Submit Payment</button>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>