<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderState;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class AdmOrdersController extends Controller
{

    /**
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(): View
    {
        if (request()?->ajax()) {
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

    /**
     * @param Order $order
     * @return View
     */
    public function edit(Order $order): View
    {
        $states = OrderState::all();
        return view('pages.orders.edit', compact('order', 'states'));
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Order $order, Request $request): RedirectResponse
    {
        $order->update($request->all());
        return redirect()->route('adm.orders.index')->with('success', 'Commande modifiée avec succès');
    }

    /**
     * @param Order $order
     * @return JsonResponse
     * @throws Exception
     */
    public function products(Order $order): JsonResponse
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
