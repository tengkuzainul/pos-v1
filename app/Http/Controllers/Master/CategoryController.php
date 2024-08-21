<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create-category')->only('store');
        $this->middleware('can:edit-category')->only('update');
        $this->middleware('can:delete-category')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryQuery = Category::query();

        if ($search) {
            $categoryQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $validSortColumns = ['name', 'created_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'name';
        }

        $categoryQuery->orderBy($sortBy, $sortOrder);

        $categories = $categoryQuery->paginate(10);

        $title = 'Delete Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('dashboard.category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.*' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\pL\s\-]+$/u',
            ],
        ]);

        $names = $request->input('name');

        $uniqueNames = array_unique($names);

        foreach ($uniqueNames as $name) {
            if (!Category::where('name', $name)->exists()) {
                Category::create(['name' => $name]);
            }
        }

        Alert::success('Create Category', 'Category data has been created successfully!');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\pL\s\-]+$/u',
            ],
        ]);

        $category = Category::findOrFail($uuid);
        $category->update(['name' => $validated['name']]);

        Alert::success('Update Category Data', 'Category data has been successfully updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
