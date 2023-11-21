<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Yajra\DataTables\DataTables;

class AdmProductsController extends Controller
{
    /**
     * @return JsonResponse|View
     * @throws Exception
     */
    public function index(): JsonResponse|View
    {
        if (request()?->ajax()) {
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

    /**
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    /**
     * @param Request $request
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(Request $request): View
    {
        $title = session()->get('title');
        $description = session()->get('description');
        $categories = Category::all();
        return view('pages.products.create', compact('categories', 'title', 'description'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $product = Product::create($request->all());
        return redirect()->route('adm.products.index')->with('success', 'Produit créé avec succès');
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Product $product, Request $request): RedirectResponse
    {
        $product->update($request->all());
        return redirect()->route('adm.products.index')->with('success', 'Produit modifié avec succès');
    }

    /**
     * @param Product $product
     * @return JsonResponse
     * @throws Exception
     */
    public function orders(Product $product): JsonResponse
    {
        $query = $product->orders;
        return DataTables::of($query)
            ->editColumn('created_at', function ($order) {
                return Carbon::parse($order->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('user', function ($order) {
                return $order->user->email;
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
     * @param Request $request
     * @return RedirectResponse
     * @throws GuzzleException
     * @throws JsonException
     */
    public function addUpc(Request $request): RedirectResponse
    {
        $lang = 'fr';
        $gtin = $request->input('upc');

        $url = 'https://live.icecat.biz/api?shopname=openIcecat-live&lang=' . $lang . '&gtin=' . $gtin;

        $client = new Client();
        $response = $client->request('GET', $url);
        $body = $response->getBody();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        $title = $data['data']['GeneralInfo']['Title'];
        $description = $data['data']['GeneralInfo']['Description']['LongDesc'];

        return redirect()->route('adm.products.create')->with('title', $title)->with('description', $description);
    }
}
