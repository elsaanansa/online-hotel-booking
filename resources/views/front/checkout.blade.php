@extends('front.layout.app')

@section('main-content')
<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $global_page_data->checkout_heading }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-6 checkout-left">

                        <form action="{{ route('payment') }}" method="post" class="frm_checkout">
                            @csrf
                            <div class="billing-info">
                                <h4 class="mb_30">Billing Information</h4>
                                @php
                                if(session()->has('billing_name')) {
                                    $billing_name = session()->get('billing_name');
                                } else {
                                    $billing_name = Auth::guard('customer')->user()->name;
                                }

                                if(session()->has('billing_email')) {
                                    $billing_email = session()->get('billing_email');
                                } else {
                                    $billing_email = Auth::guard('customer')->user()->email;
                                }

                                if(session()->has('billing_phone')) {
                                    $billing_phone = session()->get('billing_phone');
                                } else {
                                    $billing_phone = Auth::guard('customer')->user()->phone;
                                }

                                if(session()->has('billing_country')) {
                                    $billing_country = session()->get('billing_country');
                                } else {
                                    $billing_country = Auth::guard('customer')->user()->country;
                                }

                                if(session()->has('billing_address')) {
                                    $billing_address = session()->get('billing_address');
                                } else {
                                    $billing_address = Auth::guard('customer')->user()->address;
                                }

                                if(session()->has('billing_state')) {
                                    $billing_state = session()->get('billing_state');
                                } else {
                                    $billing_state = Auth::guard('customer')->user()->state;
                                }

                                if(session()->has('billing_city')) {
                                    $billing_city = session()->get('billing_city');
                                } else {
                                    $billing_city = Auth::guard('customer')->user()->city;
                                }

                                if(session()->has('billing_zip')) {
                                    $billing_zip = session()->get('billing_zip');
                                } else {
                                    $billing_zip = Auth::guard('customer')->user()->zip;
                                }
                                @endphp
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="">Name: *</label>
                                        <input type="text" class="form-control mb_15" name="billing_name" value="{{ $billing_name }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">Email Address: *</label>
                                        <input type="text" class="form-control mb_15" name="billing_email" value="{{ $billing_email }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">Phone Number: *</label>
                                        <input type="text" class="form-control mb_15" name="billing_phone" value="{{ $billing_phone }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">Country: *</label>
                                        <input type="text" class="form-control mb_15" name="billing_country" value="{{ $billing_country }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">Address: *</label>
                                        <input type="text" class="form-control mb_15" name="billing_address" value="{{ $billing_address }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">State: *</label>
                                        <input type="text" class="form-control mb_15" name="billing_state" value="{{ $billing_state }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">City:</label>
                                        <input type="text" class="form-control mb_15" name="billing_city" value="{{ $billing_city }}">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">Zip Code:</label>
                                        <input type="text" class="form-control mb_15" name="billing_zip" value="{{ $billing_zip }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary bg-website mb_30">Continue to payment</button>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-6 checkout-right">
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
                                    ( {{ $arr_cart_checkin_date[$i] }} -  {{ $arr_cart_checkout_date[$i] }})
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
                                            echo 'Rp. ' . $room_data->price * $diff;
                                        @endphp
                                        </td>
                                    </tr>
                                    @php
                                    $total_price = $total_price+($room_data->price*$diff);
                                    @endphp
                                    @endforeach
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

                                        @endphp
                                        </b>
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
        @endsection
