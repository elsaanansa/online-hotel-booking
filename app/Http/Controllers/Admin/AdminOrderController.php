<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::get();
        return view('admin.orders', compact('orders'));
    }

    public function invoice($id)

    {
        $order = Order::where('id',$id)->first();
        $order_detail = OrderDetail::where('order_id',$id)->get();
        $customer_data = Customer::where('id',$order->customer_id)->first();
        return view('admin.invoice', compact('order','order_detail','customer_data'));
    }

    public function delete($id) {
        $obj = Order::where('id',$id)->delete();
        $obj = OrderDetail::where('order_id',$id)->delete();

        return redirect()->back()->with('success', 'Order is deleted successfully');
    }

    public function DetailProofOfPayment($id) {
        $data = Order::where('id', $id)->first();

        return view('admin.detail_proof_of_payment', compact('data'));
    }

    public function ConfirmManualPayment($id) {
        $data = Order::where('id', $id)->first();

        $data->status = 'Completed';

        $data->update();
        return redirect()->route('admin_orders')->with('success', 'Order is update successfully');
    }
}
