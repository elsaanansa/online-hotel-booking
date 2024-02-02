@extends('admin.layout.app')

@section('heading', 'Customer Orders')

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Order No</th>
                                    <th>Paying Method</th>
                                    <th>Booking Date</th>
                                    <th>Paid Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($orders as $row)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->order_no }}</td>
                                    <td>{{ $row->payment_method }}</td>
                                    <td>{{ $row->booking_date }}</td>
                                    <td>@if ($row->payment_method == 'Manual')
                                            {{ 'Rp.' . $row->paid_amount }}
                                        @endif
                                        @if ($row->payment_method == 'PayPal' || $row->payment_method == 'Stripe')
                                            {{ '$' . $row->paid_amount }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->status == 'Completed')
                                            <div class="badge badge-success">{{$row->status}}</div>
                                        @endif
                                        @if ($row->status == 'Pending')
                                            <div class="badge badge-warning text-dark">{{$row->status}}</div>
                                        @endif
                                    </td>

                                    <td class="pt_10 pb_10">
                                        @if ($row->status == 'Completed')
                                        <a href="{{ route('admin_invoice',$row->id) }}" class="btn btn-primary">Detail</a>
                                        @endif
                                        @if ($row->payment_method == 'Manual' && $row->status == 'Pending')
                                        <a href="{{ route('admin_detail_proofofpayment', $row->id)}}" class="btn btn-primary">Detail Proof of Payment</a>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
