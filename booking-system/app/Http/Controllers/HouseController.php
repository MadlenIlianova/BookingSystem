<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Settlement;
use App\Models\ObjectType;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index(Request $request)
    {
        $query = House::with(['settlement', 'objectType']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('settlement', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('settlement_id')) {
            $query->where('settlement_id', $request->settlement_id);
        }

        if ($request->filled('object_type_id')) {
            $query->where('object_type_id', $request->object_type_id);
        }

        $allowedSorts = ['name', 'beds_count', 'created_at'];
        if ($request->filled('sort') && in_array($request->sort, $allowedSorts)) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->latest();
        }

        $houses = $query->paginate(10)->withQueryString();
        $settlements = Settlement::orderBy('name')->get();
        $objectTypes = ObjectType::orderBy('name')->get();

        return view('admin.houses.index', compact('houses', 'settlements', 'objectTypes'));
    }

    public function create()
    {
        $settlements = Settlement::orderBy('name')->get();
        $objectTypes = ObjectType::orderBy('name')->get();
        return view('admin.houses.create', compact('settlements', 'objectTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'settlement_id' => 'required|exists:settlements,id',
            'beds_count' => 'required|integer|min:1',
            'object_type_id' => 'required|exists:object_types,id',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048', // 2MB max per image
        ]);

        $house = House::create($request->except('images'));

        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('houses', 'public');
                
                $house->images()->create([
                    'path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                    'is_main' => $index === 0, // First image is main
                ]);
            }
        }

        return redirect()->route('admin.houses.index')
            ->with('success', 'Къща за почивка е добавена успешно');
    }

    public function edit(House $house)
    {
        $settlements = Settlement::orderBy('name')->get();
        $objectTypes = ObjectType::orderBy('name')->get();
        return view('admin.houses.edit', compact('house', 'settlements', 'objectTypes'));
    }

    public function update(Request $request, House $house)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'settlement_id' => 'required|exists:settlements,id',
            'beds_count' => 'required|integer|min:1',
            'object_type_id' => 'required|exists:object_types,id',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $house->update($request->except('images'));

        // Upload new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('houses', 'public');
                
                // If this is the first image and house has no main image, make it main
                $isMain = $house->images()->count() === 0 && $index === 0;
                
                $house->images()->create([
                    'path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                    'is_main' => $isMain,
                ]);
            }
        }

        return redirect()->route('admin.houses.index')
            ->with('success', 'Къща за почивка е обновена успешно');
    }

    public function destroy(House $house)
    {
        // Delete all images from storage
        foreach ($house->images as $image) {
            \Storage::disk('public')->delete($image->path);
        }
        
        $house->delete();

        return redirect()->route('admin.houses.index')
            ->with('success', 'Къща за почивка е изтрита успешно');
    }
}