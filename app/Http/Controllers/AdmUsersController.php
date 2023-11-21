<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gender;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class AdmUsersController extends Controller
{

    /**
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(): View|JsonResponse
    {
        if (request()?->ajax()) {
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

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $genders = Gender::all();
        return view('pages.users.edit', compact('user', 'genders'));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(User $user, Request $request): RedirectResponse
    {
        $user->update($request->all());
        return redirect()->route('adm.users.index')->with('success', 'Utilisateur modifié avec succès');
    }

    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function orders(User $user, Request $request): JsonResponse
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
            ->addColumn('actions', 'actions.orders')
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function cart(User $user, Request $request): JsonResponse
    {
        $query = $user->cart;
        return DataTables::of($query)
            ->editColumn('created_at', function ($product) {
                return Carbon::parse($product->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('amount', function ($product) {
                return $product->pivot->amount;
            })
            ->make(true);
    }
}
