<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\WebProfile;
use PayPal\Api\InputFields;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use Gloudemans\Shoppingcart\Facades\Cart;

//namespace Sample\CaptureIntentExamples;

/*use PayPalCheckoutSdk\Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;*/
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*see pp-checkout.blade.php and wep.php  */
// Route::post('create-payment', function () {
//     return 'c p working';
// });

// Route::post('execute-payment', function (Request $request) {
//     return 'e p working';
// });

/*see create-payment function in laravel_ecommerce_notes or WEBSITE_PROJECTS\LARAVEL\
  create-payment.php for original code*/

//Route::post('create-payment', function () { return 'e p working'; });

/*Route::post('create-payment', function () {

    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = buildRequestBody();
   // 3. Call PayPal to set up a transaction
    $client = PayPalClient::client();
    $response = $client->execute($request);

    echo dd($response);

    //return $response;
    //echo json_encode($response->result, JSON_PRETTY_PRINT);

    function buildRequestBody()
    {
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => 'https://example.com/return',
                    'cancel_url' => 'https://example.com/cancel'
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => 'USD',
                                    'value' => '220.00'
                                )
                        )
                )
        );
    }
    
});*/

Route::post('create-payment', function () {

    $clientId = config('services.paypal.client_id'); //see services.php
    $clientSecret = config('services.paypal.secret');

    $environment = new SandboxEnvironment($clientId, $clientSecret);
    $client = new PayPalHttpClient($environment);

    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');

    //$request->body = buildRequestBody();

    // 3. Call PayPal to set up a transaction
    $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "123456",
                "amount" => [
                    "value" => "10",
                    "currency_code" => "USD"
                    //put other details here as well related to your order
                ]
            ]],
            "application_context" => [
                "cancel_url" => "http://127.0.0.1:8000/",
                "return_url" => "http://127.0.0.1:8000/"
            ]
    ];

    try {
        // Call API with your client and get a response for your call
        $response = $client->execute($request);
        
        // If call returns body in response, you can get the deserialized version from the result attribute of the response
        echo json_encode($response); die;
    }
    catch (HttpException $ex) {
        echo $ex->statusCode;
        //echo json_encode($ex->getMessage());
    }

    //echo dd($response);

    //return $response;
    //echo json_encode($response->result, JSON_PRETTY_PRINT);

    /*function buildRequestBody()
    {
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => 'https://example.com/return',
                    'cancel_url' => 'https://example.com/cancel'
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => 'USD',
                                    'value' => '220.00'
                                )
                        )
                )
        );
    }*/
    
});

Route::post('execute-payment/{orderId}', function ($orderId) {
    $clientId = config('services.paypal.client_id'); //see services.php
    $clientSecret = config('services.paypal.secret');

    $environment = new SandboxEnvironment($clientId, $clientSecret);
    $client = new PayPalHttpClient($environment);

    // Here, OrdersCaptureRequest() creates a POST request to /v2/checkout/orders
    // $response->result->id gives the orderId of the order created above
    $request = new OrdersCaptureRequest($orderId);
    $request->prefer('return=representation');
    try {
        // Call API with your client and get a response for your call
        $response = $client->execute($request);
        
        // If call returns body in response, you can get the deserialized version from the result attribute of the response
        echo json_encode($response); die;
    }
    catch (HttpException $ex) {
        echo $ex->statusCode; die;
        //print_r($ex->getMessage());
    }
});


