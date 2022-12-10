<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Sale/Index', [
            'sales' => Sale::paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Sale/Create', [
            'clients' => Inertia::lazy(fn () => $this->getClients($request)),
            'selectedClient' => Inertia::lazy(fn () => $this->getSelectedClient($request)),
            'products' => Inertia::lazy(fn () => $this->getProducts($request)),
            'selectedProduct' => Inertia::lazy(fn () => $this->getSelectedProduct($request)),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSaleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newSale = Sale::create($request->all());
        $newSale->Details()->createMany($request->shopping_cart);
        return redirect()->route('sale.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale =  Sale::with(['details.product', 'user', 'client'])->find($id);
        $pdf = Pdf::loadView('sale', [
            'sale' => $sale,
        ]);
        return $pdf->stream("Factura-$sale->invoice_number.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSaleRequest  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

    private function getClients(Request $request)
    {
        if ($request->has('q') && $request->filled('q')) {
            return Client::where('name', 'like', "%$request->q%")->get(['id', 'name', 'nit']);
        } else {
            return Client::all(['id', 'name', 'nit']);
        }
    }

    private function getSelectedClient(Request $request)
    {
        if ($request->has('id') && $request->filled('id')) {
            return Client::find($request->id);
        }
    }

    private function getProducts(Request $request)
    {
        $columns = ['id', 'name', 'price'];
        if ($request->has('q') && $request->filled('q')) {
            return Product::where('name', 'like', "%$request->q%")->get($columns);
        } else {
            return Product::all($columns);
        }
    }

    private function getSelectedProduct(Request $request)
    {
        if ($request->has('id') && $request->filled('id')) {
            return Product::find($request->id);
        }
    }
}
