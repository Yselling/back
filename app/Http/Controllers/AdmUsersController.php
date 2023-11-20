<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdmUsersController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = User::all();
            return DataTables::of($query)
                ->editColumn('created_at', function ($user) {
                    return Carbon::parse($user->created_at)->format('d/m/Y H:i:s');
                })
                ->addColumn('gender', function ($user) {
                    return $user->gender->name;
                })
                ->addColumn('orders', function ($user) {
                    return $user->orders->count();
                })
                ->addColumn('actions', 'actions.users')
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('pages.users.index');
    }

    public function edit(User $user)
    {
        $genders = Gender::all();
        return view('pages.users.edit', compact('user', 'genders'));
    }

    public function update(User $user, Request $request)
    {
        $user->update($request->all());
        return redirect()->route('adm.users.index')->with('success', 'Utilisateur modifié avec succès');
    }

    public function orders(User $user, Request $request)
    {
        $query = $user->orders()->get();
        return DataTables::of($query)
            ->editColumn('created_at', function ($order) {
                return Carbon::parse($order->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('products_number', function ($order) {
                return $order->products->count();
            })
            ->addColumn('status', function ($order) {
                return $order->orderState()->first()->name;
            })
            ->addColumn('actions', 'actions.users')
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function cart(User $user, Request $request)
    {
        $query = $user->cart;
        return DataTables::of($query)
            ->editColumn('created_at', function ($product) {
                return Carbon::parse($product->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('amount', function ($product) {
                return $product->pivot->amount;
            })
            ->addColumn('actions', 'actions.users')
            ->rawColumns(['actions'])
            ->make(true);
    }
}
