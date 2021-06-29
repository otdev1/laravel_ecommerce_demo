<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            

            <div class="content">
                
            <script
                src="https://www.paypal.com/sdk/js?client-id=Ae0i5fFDXZJRcUKnSD34kxbNem_iK1KXWryUeZFTG8IB3XYFt3UOGKCPba7X0IeW8lQG1k5OStiSx75y"> // Required. Replace YOUR_CLIENT_ID with your sandbox client ID.
            </script>

                <div class="links">

                    <!-- <div id="paypal-button"></div> -->

                    

                    <div id="paypal-button-container"></div>

                </div>
            </div>
        </div>

        <script>

            //see https://developer.paypal.com/docs/checkout/reference/server-integration/set-up-transaction-authorize/#on-the-client
            
            paypal.Buttons({
                createOrder: function() {
                    return fetch('/api/create-payment', {
                        method: 'post',
                        headers: {
                        'content-type': 'application/json'
                        }
                    }).then(function(res) {
                        return res.json();
                    }).then(function(data) {
                        return data.id; // Use the key sent by your server's response, ex. 'id' or 'token'
                    });
                    /*return fetch('/api/create-payment/', {
                        method: 'post',
                        headers: {
                        'content-type': 'application/json'
                        }
                    }).then(function(res) {
                        //return res.json();
                        console.log(res);
                    });*/
                    /*return fetch('/api/create-payment/', {
                        method: 'post',
                        headers: {
                        'content-type': 'application/json'
                        }
                    });*/
                }
            }).render('#paypal-button-container');
            // This function displays Smart Payment Buttons on your web page.
        </script>

        
            <!--<script src="https://www.paypalobjects.com/api/checkout.js"></script>-->
            <!--<script>

                /*code below is used for client side integration i.e client calls paypal API 
                see https://developer.paypal.com/docs/archive/checkout/integrate/ */
                paypal.Button.render({
                    // Configure environment
                    env: 'sandbox',
                    client: {
                        sandbox: 'Ae0i5fFDXZJRcUKnSD34kxbNem_iK1KXWryUeZFTG8IB3XYFt3UOGKCPba7X0IeW8lQG1k5OStiSx75y',
                        production: 'demo_production_client_id'
                    },
                    // Customize button (optional)
                    locale: 'en_US',
                    style: {
                    size: 'large',
                    color: 'gold',
                    shape: 'pill',
                    },

                    // Enable Pay Now checkout flow (optional)
                    commit: true,

                    // Set up a payment
                    /*the payment function gathers all of the paypal account information of logged in user
                    the total amount and currency of that amount is passed*/
                    payment: function(data, actions) {
                    return actions.payment.create({
                        transactions: [{
                        amount: {
                            total: '0.01',
                            currency: 'USD'
                        }
                        }]
                    });
                    },
                    // Execute the payment
                    onAuthorize: function(data, actions) {
                    return actions.payment.execute().then(function() {
                        // Show a confirmation message to the buyer
                        window.alert('Thank you for your purchase!');
                    });
                    }
                }, '#paypal-button');

            </script>-->

            <!--<script>
                /*code below is used for server side integration i.e client sends request to laravel server, 
                the laravel server then makes calls to the paypal API
                see https://developer.paypal.com/docs/archive/checkout/how-to/server-integration/ */

                paypal.Button.render({
                    env: 'sandbox', // Or 'production'

                    // Customize button (optional)
                    locale: 'en_US',
                    style: {
                        size: 'large',
                        color: 'gold',
                        shape: 'pill',
                    },

                    // Set up the payment:
                    // 1. Add a payment callback

                    payment: function(data, actions) {

                        // 2. Make a request to your server
                        return actions.request.post('/api/create-payment/') // see api.php
                            .then(function(res) {
                            /* 3. Return res.id i.e a token or payment id from the response this id has all the information
                             associated with the account of the logged in user*/
                            console.log(res);
                            return res.id;
                            });
                    },
                    // Execute the payment:
                    // 1. Add an onAuthorize callback
                    onAuthorize: function(data, actions) {
                    // 2. Make a request to your server
                    return actions.request.post('/api/execute-payment/', { // see api.pp
                        paymentID: data.paymentID, //data.payment is provided by res.id
                        payerID:   data.payerID //data.payerID is provided by res.id
                    })
                        .then(function(res) {
                        // 3. Show the buyer a confirmation message.
                        console.log(res);
                        alert('PAYMENT WENT THROUGH!!');

                        });
                    }
                }, '#paypal-button');
            </script>-->

    </body>
</html>
