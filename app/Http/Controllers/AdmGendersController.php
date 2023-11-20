<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gender;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class AdmGendersController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
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

    public function edit(Gender $gender)
    {
        return view('pages.genders.edit', compact('gender'));
    }

    public function create(Request $request)
    {
        return view('pages.genders.create');
    }

    public function store(Request $request)
    {
        $gender = Gender::create($request->all());
        return redirect()->route('adm.genders.index')->with('success', 'Genre créé avec succès');
    }

    public function update(Gender $gender, Request $request)
    {
        $gender->update($request->all());
        return redirect()->route('adm.genders.index')->with('success', 'Genre modifiée avec succès');
    }

    public function users(Gender $gender)
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
