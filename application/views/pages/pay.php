<div class="container">
	<div class="hero-unit">
		<div class="row">
				<div class="span9">
					<h2>
						Hi <?= $user->name ?>, pay your share easily and quickly!
					</h2>
				</div>
		</div>
	</div>
	<div class="row top-bottom-space-sm">
		<div class="payment-errors">
		</div>
	</div>
	<div class="row top-bottom-space-sm">
		<div class="span3 payment-box">
			<form action="" method="POST" id="payment-form">
				<div class="form-row">
					<label>Name:</label>
					<i class="special-msg"><?= $user->name ?></i>				
				</div>
				<div class="form-row">
					<label>Amount You Owe:</label>
					<i class="special-msg">$<?= number_format($amt) ?></i>				
				</div>
				<div class="form-row">
					<label>Email:</label>
					<input name="email" type="text" size="20" autocomplete="off"/>
					<input name="userid" type="hidden" size="20" value="<?= $user->userid ?>" autocomplete="off"/>				
				</div>
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
					<input type="text" size="2" class="card-expiry-month input_sm"/>				
					<span>/</span>
					<input type="text" size="4" class="card-expiry-year input_sm"/>				
				</div>
				<button type="submit" class="submit-button">Submit Payment</button>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>