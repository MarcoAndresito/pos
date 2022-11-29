<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('q') && $request->filled('q')) {
            $clients = Client::where('name', 'like', "%$request->q%")->get();
        } else {
            $clients = Client::all();
        }
        return Inertia::render('Client/Index', [
            'clients' => $clients,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nit' => 'required',
            'name' => 'required',
        ]);
        $newClient = Client::create($request->all());
        if ($request->has('backurl') && $request->filled('backurl')) {
            return redirect()->route($request->backurl, ['id' => $newClient->id]);
        }
    }
}
