<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdmProductsController extends Controller
{
    // public function index()
    // {
    //     return view('pages.products.index');
    // }

    public function index()
    {
        if (request()->ajax()) {
            $query = Product::all();
            return DataTables::of($query)
                // ->editColumn('created_at', function ($user) {
                //     return Carbon::parse($user->created_at)->format('d/m/Y H:i:s');
                // })
                // ->editColumn('email_verified_at', function ($user) {
                //     return $user->email_verified_at != null ? Carbon::parse($user->email_verified_at)->format('d/m/Y H:i:s') : 'Non vérifié';
                // })
                ->addColumn('category', function ($product) {
                    return $product->category->name;
                })
                ->addColumn('orders', function ($product) {
                    return $product->orders->count();
                })
                // ->addColumn('actions', 'administration.tables.users.actions')
                // ->rawColumns(['actions'])
                ->make(true);
        }
        return view('pages.products.index');
    }
}
