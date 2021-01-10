<?php
// This is your real test secret API key.
namespace App\Http\Controllers\StripeRelated;
require('vendor/autoload.php');

class StripeCreate
{

    public static function createOrder($debug=false){
        \Stripe\Stripe::setApiKey(env('STRIPE_S_KEY'));

        header('Content-Type: application/json');
        try {
        // retrieve JSON from POST body
        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str);
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $json_obj->price * 100,
            'currency' => 'usd',
        ]);
        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];
        echo json_encode($output);
        } catch (Error $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        }
}
}

?>