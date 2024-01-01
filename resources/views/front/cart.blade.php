@extends('front.layout.app')

@section('main-content')
<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2> {{ $global_page_data->cart_heading }} </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row-cart">
            <div class="col-md-12">

            @if(session()->has('cart_room_id'))

            <div class="table-responsive">
                <table class="table table-bordered table-cart">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Serial</th>
                            <th>Photo</th>
                            <th>Room Info</th>
                            <th>Price/Night</th>
                            <th>Checkin</th>
                            <th>Checkout</th>
                            <th>Guest</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $arr_cart_room_id = session()->get('cart_room_id', []);
                            $arr_cart_checkin_date = session()->get('cart_checkin_date', []);
                            $arr_cart_checkout_date = session()->get('cart_checkout_date', []);
                            $arr_cart_adult = session()->get('cart_adult', []);
                            $arr_cart_children = session()->get('cart_children', []);

                            $total_price = 0;
                            
                        @endphp

                        @foreach ($arr_cart_room_id as $i => $room_id )
                        @php
                            $room_data = DB::table('rooms')->where('id', $room_id)->first();
                        @endphp

                        <tr>
                            <td>
                                <a href="{{ route('cart_delete', $room_id) }}" class="cart-delete-link" onclick="return confirm('Are you sure?');"><i class="fa fa-times"></i></a>
                            </td>
                            <td>{{ $i + 1 }}</td>
                            <td><img src="{{ asset('uploads/' .$room_data->featured_photo) }}" style="width:100px; height: auto;"></td>

                            <td>
                                <a href="{{ route('room_detail', $room_data->id) }}" class="room_name">{{ $room_data->name }}</a>
                            </td>
                            <td>Rp. {{ $room_data->price }}</td>
                            <td>
                                @if(isset($arr_cart_checkin_date[$i]))
                                {{ $arr_cart_checkin_date[$i] }}
                                @endif
                            </td>
                            <td>
                                @if(isset($arr_cart_checkout_date[$i]))
                                {{ $arr_cart_checkout_date[$i] }}
                                @endif
                            </td>
                            <td>
                               Adult: {{ $arr_cart_adult[$i] }}<br>
                               Children: {{ $arr_cart_children[$i] }}
                            </td>
                            <td>
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
                            <td colspan="8" class="tar">Total:</td>
                            <td>Rp. {{ $total_price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="checkout mb_20">
                <a href="{{ route('checkout') }}" class="btn btn-primary bg-website">Checkout</a>
            </div>

            @else
            <div class="text-danger mb_30">
                Cart is empty!
            </div>
            @endif

            </div>
        </div>
    </div>
</div>
@endsection








