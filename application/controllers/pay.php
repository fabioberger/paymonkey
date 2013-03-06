<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pay extends MY_Controller {
public function index(){
	if (!empty($_POST['stripeToken'])) {
		require_once("application/libraries/stripe/lib/Stripe.php");
		// set your secret key: remember to change this to your live secret key in production
		// see your keys here https://manage.stripe.com/account
		Stripe::setApiKey("ADD_STRING_KEY_HERE");
		// get the credit card details submitted by the form
		$token = $_POST['stripeToken'];
		$userid = (int)$_POST['userid'];
		$email = $_POST['email'];
		$groupid = (int) $_GET['groupid'];
		$this->load->library('UserLib', '', 'user_lib');
		$amt = $this->user_lib->getIndividualAmount($groupid);
		// charge the Customer
		$error = '';
		try {
			// create a Customer
			$customer = Stripe_Customer::create(array(
				"card" => $token,
				"description" => $email
			));

			$response = Stripe_Charge::create(array(
				"amount" => $amt*100, # amount in cents, again
				"currency" => "usd",
				"customer" => $customer->id
			));
		} catch (Exception $e) {
			$error = $e->getMessage();
		}

		if ($error=='') {
			if (!$this->user_lib->setEmail($userid, $email)) throw new Exception("Couldn't store email.");
			if (!$this->user_lib->setPaid($userid, $groupid, 1, $response->created)) throw new Exception("Couldn't mark as paid.");
			$message = "Thank you for your payment! <br/><br/>Your payment of $".number_format($amt)." has been recorded and your group leader will know you've paid. <br/><br/>Have a great day!";
		} else {
			$message = "Sorry, didn't go through. Error: $error";
		}

		$this->title = $message;
		$this->data['message'] = $message;
		$this->_render('pages/pay_ty');
	} else {
		if (empty($_GET['payerid']) || !is_numeric($_GET['payerid']) || empty($_GET['groupid']) || !is_numeric($_GET['groupid'])) {
			$this->showPayError(); return false;
		}

		$userid = (int) $_GET['payerid'];
		$groupid = (int) $_GET['groupid'];
		$this->load->library('UserLib', '', 'user_lib');
		$user = $this->user_lib->getUser($userid);
		$paid = $this->user_lib->getPaid($userid, $groupid);
		$amt = $this->user_lib->getIndividualAmount($groupid);

		if ($paid) {
			$this->data['amt'] = $amt;
			$this->data['user'] = $user;
			$this->title = "This payment has already been successfully paid!";
			$this->_render('pages/pay_paid');
			return;
		}

		if (!$user || !isset($user->name) || $user->name=="") { $this->showPayError(); return false; } 

		$this->title = "Hi $user->name, pay your share now!";
		$this->css[] = "pay.css";
		$this->javascript[] = "stripe/stripe_pub.js";
		$this->data['amt'] = $amt;
		$this->data['user'] = $user;
		$this->_render('pages/pay');
	}
}

private function showPayError(){
	$this->title = "Oops! Something went wrong.";
	$this->_render('pages/pay_error');
	return;
}
}