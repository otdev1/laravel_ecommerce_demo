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

use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

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

Route::post('create-payment', function () {

    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = buildRequestBody();
   // 3. Call PayPal to set up a transaction
    $client = PayPalClient::client();
    $response = $client->execute($request);

    return $response;
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
    
});


