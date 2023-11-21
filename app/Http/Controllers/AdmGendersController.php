<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gender;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class AdmGendersController extends Controller
{

    /**
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(): View|JsonResponse
    {
        if (request()?->ajax()) {
            $query = Gender::all();
            return DataTables::of($query)
                ->editColumn('created_at', function ($gender) {
                    return Carbon::parse($gender->created_at)->format('d/m/Y H:i:s');
                })
                ->addColumn('actions', 'actions.genders')
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('pages.genders.index');
    }

    /**
     * @param Gender $gender
     * @return View
     */
    public function edit(Gender $gender): View
    {
        return view('pages.genders.edit', compact('gender'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        return view('pages.genders.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $gender = Gender::create($request->all());
        return redirect()->route('adm.genders.index')->with('success', 'Genre créé avec succès');
    }

    /**
     * @param Gender $gender
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Gender $gender, Request $request): RedirectResponse
    {
        $gender->update($request->all());
        return redirect()->route('adm.genders.index')->with('success', 'Genre modifiée avec succès');
    }

    /**
     * @param Gender $gender
     * @return JsonResponse
     * @throws Exception
     */
    public function users(Gender $gender): JsonResponse
    {
            $query = $gender->users()->get();
            return DataTables::of($query)
                ->editColumn('created_at', function ($user) {
                    return Carbon::parse($user->created_at)->format('d/m/Y H:i:s');
                })
                ->addColumn('orders', function ($user) {
                    return $user->orders->count();
                })
                ->addColumn('actions', 'actions.users')
                ->rawColumns(['actions'])
                ->make(true);
    }
}
