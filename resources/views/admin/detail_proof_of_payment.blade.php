@extends('admin.layout.app')

@section('heading', 'Confirm Payment Manual')

@section('right_top_button')

    <a href="{{ route('admin_orders') }}" class="btn btn-primary"><i class="fa fa-eye"></i>View All</a>

@endsection


@section('main_content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="card d-inline">
                                    <img class="card-img-top" style="width: 200px"
                                        src="{{ asset($data->proof_of_payment) }}" alt="Title" />
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <form action="{{route('admin_manualpayment_confirm', $data->id)}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Konfirm Payment</button>
                                            </form>
                                        </h4>
                                        <p class="card-text">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="invoice-title">

                                                    <div class="invoice-number">Order #{{ $data->order_no }}</div>
                                                    <div class="invoice-date">Date #{{ $data->booking_date }}</div>
                                                </div>
                                                >
                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
