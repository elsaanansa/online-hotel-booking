@extends('front.layout.app')

@section('main-content')


<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $global_page_data->payment_heading }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
            <div class="container">
                <div class="row">
                <div class="col-lg-4 col-md-4 checkout-left mb_30">

                                @php
                            $arr_cart_room_id = session()->get('cart_room_id', []);
                            $arr_cart_checkin_date = session()->get('cart_checkin_date', []);
                            $arr_cart_checkout_date = session()->get('cart_checkout_date', []);
                            $arr_cart_adult = session()->get('cart_adult', []);
                            $arr_cart_children = session()->get('cart_children', []);

                            $total_price = 0;

                            @endphp
                            @foreach($arr_cart_room_id as $i => $room_id)
                            @php
                            $room_data = DB::table('rooms')->where('id', $room_id)->first();
                            $d1 = explode('/', $arr_cart_checkin_date[$i]);
                            $d2 = explode('/', $arr_cart_checkout_date[$i]);
                            $d1_new = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
                            $d2_new = $d2[2] . '-' . $d2[1] . '-' . $d2[0];
                            $t1 = strtotime($d1_new);
                            $t2 = strtotime($d2_new);
                            $exchange_rate = 15444;
                            $diff = ($t2 - $t1) / 60 / 60 / 24;

                            $price_in_rupiah = $room_data->price * $diff;
                            $price_in_dollars = $price_in_rupiah / $exchange_rate;

                            number_format($price_in_dollars, 2, '.', ',');
                            @endphp
                            @endforeach

                        <h4>Make Payment</h4>
                        <select name="payment_method" class="form-control select2" id="paymentMethodChange" autocomplete="off">
                            <option value="">Select Payment Method</option>
                            <option value="PayPal">PayPal</option>
                            <option value="Stripe">Stripe</option>
                            <option value="Midtrans">Midtrans</option>
                        </select>

                        <div class="paypal mt_20">
                            <h4>Pay with PayPal</h4>
                            <div id="paypal-button"></div>
                        </div>


                            <div class="stripe mt_20">
                                        <h4>Pay with Stripe</h4>
                                        @php
                                            $cents = $price_in_dollars*100;
                                            $customer_email = Auth::guard('customer')->user()->email;
                                            $stripe_publishable_key = 'pk_test_51O8gHyGMon457AwDJ98dxEsdMxcdG96C0KyySqECBZ5yg1JAQaOYXMdeTTIP4lvsWTiupPvXL2aIQjyluhFGdQeR00uyIemWQE';
                                        @endphp
                                    <form action="{{ route('stripe',$price_in_dollars) }}" method="post">
                                        @csrf
                                        <script
                                            src="https://checkout.stripe.com/checkout.js"
                                            class="stripe-button"
                                            data-key="{{ $stripe_publishable_key }}"
                                            data-amount="{{ $cents }}"
                                            data-name="{{ env('APP_NAME') }}"
                                            data-description=""
                                            data-image="{{ asset('uploads/stripe.png') }}"
                                            data-currency="usd"
                                            data-email="{{ $customer_email }}"
                                        >
                                        </script>
                                     </form>
                            </div>


                            <div class="midtrans mt_20" style="display: none;">
                                <h4>Pay with Midtrans</h4>

                                <button type="submit" class="btn btn-primary">Checkout</button>

                                
                            </div>

                    </div>

                    <div class="col-lg-4 col-md-4 checkout-right">
                    <div class="inner">
                            <h4 class="mb_10">Billing Details</h4>
                            <div>
                              Name: {{ session()->get('billing_name') }}
                            </div>
                            <div>
                              Email: {{ session()->get('billing_email') }}
                            </div>
                            <div>
                              Phone: {{ session()->get('billing_phone') }}
                            </div>
                            <div>
                              Country: {{ session()->get('billing_country') }}
                            </div>
                            <div>
                              Address: {{ session()->get('billing_address') }}
                            </div>
                            <div>
                              State: {{ session()->get('billing_state') }}
                            </div>
                            <div>
                              City: {{ session()->get('billing_city') }}
                            </div>
                            <div>
                              Zip: {{ session()->get('billing_zip') }}
                            </div>
                    </div>
                    </div>
                    <div class="col-lg-4 col-md-4 checkout-right">
                        <div class="inner">
                            <h4 class="mb_10">Cart Details</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>

                            @php
                            $arr_cart_room_id = session()->get('cart_room_id', []);
                            $arr_cart_checkin_date = session()->get('cart_checkin_date', []);
                            $arr_cart_checkout_date = session()->get('cart_checkout_date', []);
                            $arr_cart_adult = session()->get('cart_adult', []);
                            $arr_cart_children = session()->get('cart_children', []);

                            $total_price = 0;

                            @endphp
                            @foreach($arr_cart_room_id as $i => $room_id)
                                @php
                                $room_data = DB::table('rooms')->where('id', $room_id)->first();
                                @endphp


                                <tr>
                                    <td>
                                            {{ $room_data->name }}
                                            <br>
                                            ( {{ $arr_cart_checkin_date[$i] }} - {{ $arr_cart_checkout_date[$i] }})
                                            <br>
                                            Adult: {{ $arr_cart_adult[$i] ?? 0 }}, Children: {{ $arr_cart_children[$i] ?? 0 }}
                                            </td>
                                                <td class="p_price">
                                                @php
                                                $d1 = explode('/',$arr_cart_checkin_date[$i]);
                                            $d2 = explode('/',$arr_cart_checkout_date[$i]);
                                            $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
                                            $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
                                            $t1 = strtotime($d1_new);
                                            $t2 = strtotime($d2_new);
                                            $diff = ($t2-$t1)/60/60/24;
                                            echo 'Rp' . $room_data->price*$diff;

                                            @endphp
                                    </td>
                                </tr>

                                    @php
                                    $total_price = $total_price+($room_data->price*$diff);
                                    @endphp
                                    @endforeach

                                    <tr>
                                        <td><b>Total:</b></td>
                                        <td class="p_price"><b>Rp{{ $total_price }}</b></td>
                                </tr>

                                <tr>
                                        <td><b>Total dalam dollar :</b></td>
                                        <td class="p_price"><b>
                                            @php
                                            $d1 = explode('/', $arr_cart_checkin_date[$i]);
                                            $d2 = explode('/', $arr_cart_checkout_date[$i]);
                                            $d1_new = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
                                            $d2_new = $d2[2] . '-' . $d2[1] . '-' . $d2[0];
                                            $t1 = strtotime($d1_new);
                                            $t2 = strtotime($d2_new);
                                            $exchange_rate = 15444;
                                            $diff = ($t2 - $t1) / 60 / 60 / 24;

                                            $price_in_rupiah = $room_data->price * $diff;
                                            $price_in_dollars = $price_in_rupiah / $exchange_rate;

                                            echo '$ ' . number_format($price_in_dollars, 2, '.', ',');

                                        @endphp</b>
                                        <!-- <b>Rp{{ $total_price }}</b></td> -->
                                </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
        $client = 'AaR8k2STvMZivADX5EaWp4akx-9y_o-RN8zcrMEOUIKDGlLssTfDIr2v_0bHQesKeyZsMlQ8FhjrfOer';

        $dollar_amt =  number_format((float)$price_in_dollars, 2, '.', '');

        @endphp
        <script>
           console.log({{$dollar_amt}})
            paypal.Button.render({
                env : 'sandbox',
                client: {
                    sandbox: '{{ $client }}',
                    production: '{{ $client }}'
                },
                locale: 'en_US',
                style: {
                    size: 'medium',
                    color: 'blue',
                    shape: 'rect',
                },
                //Set up a payment
                payment: function (data, actions) {
                    return actions.payment.create({
                        redirect_urls:{
                            return_url: '{{ url("payment/paypal/$total_price") }}'
                        },
                        transactions: [{
                            amount: {
                                total: '{{ $dollar_amt }}',
                                currency: 'USD'
                            }
                        }]
                    });
                },
                //Execute the payment
                onAuthorize: function (data, actions) {
                    return actions.redirect();
                }
            }, '#paypal-button');
        </script>
        @endsection
