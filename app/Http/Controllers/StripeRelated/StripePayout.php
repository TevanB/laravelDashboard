<?php
// This is your real test secret API key.
namespace App\Http\Controllers\StripeRelated;
//require __DIR__ . '/vendor/autoload.php';
require_once('stripe-php/init.php');

class StripePayout
{

    public static function createAcc($debug=false){
        \Stripe\Stripe::setApiKey('sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963');
        try{
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);


            $stripe = new \Stripe\StripeClient(
                'sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963'
              );
            $newAcc = $stripe->accounts->create([
            'type' => 'express',
            'country' => 'US',
            'email' => $json_obj->email,
            ]);

            echo(createAccLink($newAcc->id));

            //echo($account);               //Call createAccLink


        }catch(Error $e){
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public static function createAccLink($id){
        \Stripe\Stripe::setApiKey('sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963');
        try{
            //$json_str = file_get_contents('php://input');
            //$json_obj = json_decode($json_str);

            $account_links = \Stripe\AccountLink::create([
                'account' => $id,
                'refresh_url' => 'https://end-setup-payou-rs8qky.herokuapp.comsetup-payou-rs8qky.herokuapp.com//profile',
                'return_url' => 'https://end-setup-payou-rs8qky.herokuapp.comsetup-payou-rs8qky.herokuapp.com//profile',
                'type' => 'account_onboarding',
            ]);
            echo($account_links);

        }catch(Error $e){
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public static function visitPayoutDash($debug=false){
        \Stripe\Stripe::setApiKey('sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963');
        try{
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);
            $stripe = new \Stripe\StripeClient(
                'sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963'
              );
            $accList = $stripe->accounts->all(['limit' => 3]);
            $accId = "";
            for ($x = 0; $x < count($accList->data); $x++) {
                if($json_obj->email == $accList->data[$x]){
                    $accId = $accList->data[$x]->id;
                }
            }
            if($accId != ""){
                echo(createAccLink($accId));
            }else{
                echo(createAcc());
            }
        }catch(Error $e){
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

?> 
