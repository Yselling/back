<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderState;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class AdmOrdersController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Order::all();
            return DataTables::of($query)
                ->editColumn('created_at', function ($category) {
                    return Carbon::parse($category->created_at)->format('d/m/Y H:i:s');
                })
                ->addColumn('name', function ($order) {
                    return $order->user->email;
                })
                ->addColumn('products', function ($order) {
                    return $order->products->count();
                })
                ->addColumn('state', function ($order) {
                    return $order->orderState->name;
                })
                ->addColumn('actions', 'actions.orders')
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('pages.orders.index');
    }

    public function edit(Order $order)
    {
        $states = OrderState::all();
        return view('pages.orders.edit', compact('order', 'states'));
    }

    public function update(Order $order, Request $request)
    {
        $order->update($request->all());
        return redirect()->route('adm.orders.index')->with('success', 'Commande modifiée avec succès');
    }

    public function products(Order $order)
    {
            $query = $order->products()->get();
            return DataTables::of($query)
                ->addColumn('quantity_order', function ($product) {
                    return $product->pivot->amount;
                })
                ->addColumn('actions', 'actions.products')
                ->rawColumns(['actions'])
                ->make(true);
    }
}
