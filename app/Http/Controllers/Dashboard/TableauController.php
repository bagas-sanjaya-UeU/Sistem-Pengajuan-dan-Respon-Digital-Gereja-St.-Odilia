<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TableauLink;
use Illuminate\Http\Request;


class TableauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableauLinks = TableauLink::latest()->get();
        return view('dashboards.tableau.index', compact('tableauLinks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'embed_code' => 'required|string',
        ]);

        TableauLink::create($request->all());

        return redirect()->route('dashboard.tableau.index')->with('success', 'Visualisasi berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TableauLink $tableau)
    {
        $tableau->delete();
        return redirect()->route('dashboard.tableau.index')->with('success', 'Visualisasi berhasil dihapus.');
    }
}
