<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class AdmCategoriesController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Category::all();
            return DataTables::of($query)
                ->editColumn('created_at', function ($category) {
                    return Carbon::parse($category->created_at)->format('d/m/Y H:i:s');
                })
                ->addColumn('actions', 'actions.categories')
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('pages.categories.index');
    }

    public function edit(Category $category)
    {
        return view('pages.categories.edit', compact('category'));
    }

    public function create(Request $request)
    {
        return view('pages.categories.create');
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return redirect()->route('adm.categories.index')->with('success', 'Catégorie créé avec succès');
    }

    public function update(Category $category, Request $request)
    {
        $category->update($request->all());
        return redirect()->route('adm.categories.index')->with('success', 'Catégorie modifiée avec succès');
    }

    public function products(Category $category)
    {
            $query = $category->products()->get();
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
                ->addColumn('orders', function ($product) {
                    return $product->orders->count();
                })
                ->addColumn('actions', 'actions.products')
                ->rawColumns(['actions'])
                ->make(true);
    }
}
