<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function index()
    {
        $settlements = Settlement::withCount('houses')->paginate(15);
        return view('admin.settlements.index', compact('settlements'));
    }

    public function create()
    {
        return view('admin.settlements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:settlements,name'
        ]);

        Settlement::create($request->all());

        return redirect()->route('admin.settlements.index')
            ->with('success', 'Населено място е добавено успешно');
    }

    public function edit(Settlement $settlement)
    {
        return view('admin.settlements.edit', compact('settlement'));
    }

    public function update(Request $request, Settlement $settlement)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:settlements,name,' . $settlement->id
        ]);

        $settlement->update($request->all());

        return redirect()->route('admin.settlements.index')
            ->with('success', 'Населено място е обновено успешно');
    }

    public function destroy(Settlement $settlement)
    {
        $settlement->delete();

        return redirect()->route('admin.settlements.index')
            ->with('success', 'Населено място е изтрито успешно');
    }
}