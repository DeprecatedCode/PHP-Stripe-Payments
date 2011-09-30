<?php

require_once('stripe-php/lib/Stripe.php');

// get the single use token from the form submitted by stripeResponseHandler
$token = @$_POST['stripeToken'];

if(strlen($token) < 1)
    die('No token to charge');

// set your secret key: remember to change this to your live secret key in production
Stripe::setApiKey("mGz5Bc7q0tFOcwUK3rU7MVdExIqGafie"); // get this from https://manage.stripe.com/account

// create a Customer
$customer = Stripe_Customer::create(array(
  "card" => $token,
  "description" => "Mr. Chaguza")
);

// charge the Customer instead of the card
Stripe_Charge::create(array(
  "amount" => 53900, # amount in cents, again
  "currency" => "usd",
  "customer" => $customer->id)
);

echo '<h1>Thank you for your business!</h1>';
