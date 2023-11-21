<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class AdmCategoriesController extends Controller
{

    /**
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(): View|JsonResponse
    {
        if (request()?->ajax()) {
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

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('pages.categories.edit', compact('category'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        return view('pages.categories.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $category = Category::create($request->all());
        return redirect()->route('adm.categories.index')->with('success', 'Catégorie créé avec succès');
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Category $category, Request $request): RedirectResponse
    {
        $category->update($request->all());
        return redirect()->route('adm.categories.index')->with('success', 'Catégorie modifiée avec succès');
    }

    /**
     * @param Category $category
     * @return JsonResponse
     * @throws Exception
     */
    public function products(Category $category): JsonResponse
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
