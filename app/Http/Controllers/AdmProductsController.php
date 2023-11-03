<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdmProductsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::all();
            return DataTables::of($query)
                ->editColumn('created_at', function ($product) {
                    return Carbon::parse($product->created_at)->format('d/m/Y H:i:s');
                })
                ->editColumn('quantity', function ($product) {
                    return number_format($product->quantity, 0, ',', ' ');
                })
                ->editColumn('price', function ($product) {
                    return number_format($product->price, 0, ',', ' ') . ' €';
                })
                ->addColumn('category', function ($product) {
                    return $product->category->name;
                })
                ->addColumn('orders', function ($product) {
                    return $product->orders->count();
                })
                ->addColumn('actions', 'actions.products')
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('pages.products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return redirect()->route('adm.products.index')->with('success', 'Produit créé avec succès');
    }

    public function update(Product $product, Request $request)
    {
        $product->update($request->all());
        return redirect()->route('adm.products.index')->with('success', 'Produit modifié avec succès');
    }
}
