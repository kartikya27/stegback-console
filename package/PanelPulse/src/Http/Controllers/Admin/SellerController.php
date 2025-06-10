<?php

namespace Kartikey\PanelPulse\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kartikey\PanelPulse\Models\Seller;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::paginate(15);    
        return view('PanelPulse::admin.sellers.list', compact('sellers'));
    }

    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        return view('PanelPulse::admin.sellers.view', compact('seller'));
    }

    public function create()
    {
        return view('PanelPulse::admin.sellers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        Seller::create($validated);
        return redirect()->route('admin.sellers')->with('success', 'Seller created successfully');
    }

    public function edit($id)
    {
        $seller = Seller::findOrFail($id);
        return view('PanelPulse::admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email,' . $id,
            'phone' => 'required|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        $seller->update($validated);
        return redirect()->route('admin.sellers')->with('success', 'Seller updated successfully');
    }

    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->delete();
        return redirect()->route('admin.sellers.index')->with('success', 'Seller deleted successfully');
    }
} 