<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Akatswiri &bull; Make a Payment</title>
        <style>
	    body {width: 400px; border-right: 2px solid #ccc; border-left: 2px solid #ccc; border-bottom: 2px solid #ccc; padding: 3em; margin: 0 auto; font-family: Sans, Arial, sans-serif; font-size: 14px; background: #eee; 
	    }
	    .form-row {
		padding: 1em 0;
	    }
	    .payment-errors {
	 	margin: 1em 0;
		background: #800;
		color: white;
		font-weight: bold;
		padding: 0.5em;
	    }
	</style>
	<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
            Stripe.setPublishableKey('pk_214wr0Sa0uYIlonYugtIzuCYOAod2');

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }

            $(document).ready(function() {
                $("#payment-form").submit(function(event) {
		    if(!confirm('Your card will be charged USD 539.00, continue?'))
			return;
                    // disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");
                    var chargeAmount = 53900; //amount you want to charge, in cents. 1000 = $10.00, 2000 = $20.00 ...
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, chargeAmount, stripeResponseHandler);
                    return false; // submit from callback
                });
            });
        </script>
    </head>
    <body>
        <h1>Pay For Your Akatswiri Purchase</h1>
	<h2>First Installment: USD 539.00 = GPB 345.00</h2>
        <!-- to display errors returned by createToken -->
        <span class="payment-errors"></span>
        <form action="charge.php" method="POST" id="payment-form">
            <div class="form-row">
                <label>Card Number</label>
                <input type="text" size="20" autocomplete="off" class="card-number" />
            </div>
            <div class="form-row">
                <label>CVC</label>
                <input type="text" size="4" autocomplete="off" class="card-cvc" />
            </div>
            <div class="form-row">
                <label>Expiration (MM/YYYY)</label>
                <input type="text" size="2" class="card-expiry-month"/>
                <span> / </span>
                <input type="text" size="4" class="card-expiry-year"/>
            </div>
            <button type="submit" class="submit-button">Submit Payment</button>
        </form>
    </body>
</html>

