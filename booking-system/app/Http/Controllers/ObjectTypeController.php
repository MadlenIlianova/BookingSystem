<?php

namespace App\Http\Controllers;

use App\Models\ObjectType;
use Illuminate\Http\Request;

class ObjectTypeController extends Controller
{
    public function index()
    {
        $objectTypes = ObjectType::withCount('houses')->paginate(15);
        return view('admin.object-types.index', compact('objectTypes'));
    }

    public function create()
    {
        return view('admin.object-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:object_types,name'
        ]);

        ObjectType::create($request->all());

        return redirect()->route('admin.object-types.index')
            ->with('success', 'Тип обект е добавен успешно');
    }

    public function edit(ObjectType $objectType)
    {
        return view('admin.object-types.edit', compact('objectType'));
    }

    public function update(Request $request, ObjectType $objectType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:object_types,name,' . $objectType->id
        ]);

        $objectType->update($request->all());

        return redirect()->route('admin.object-types.index')
            ->with('success', 'Тип обект е обновен успешно');
    }

    public function destroy(ObjectType $objectType)
    {
        $objectType->delete();

        return redirect()->route('admin.object-types.index')
            ->with('success', 'Тип обект е изтрит успешно');
    }
}
