<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function categoriesIndex()
    {
        return view('admin.categories.index');
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon_class' => 'nullable|string',
            'dark_icon_class' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:webp|max:2048',
            'dark_image_path' => 'nullable|image|mimes:webp|max:2048',
        ]);

        $slug = Str::slug($validated['name']);

        if (Category::where('slug', $slug)->exists()) {
            throw ValidationException::withMessages([
                'name' => ['The generated slug "' . $slug . '" already exists. Please choose a different name.'],
            ]);
        }

        // Upload files if present
        $imagePath = null;
        $darkImagePath = null;

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = Str::slug($imageName) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/icons'), $imageName);
            $imagePath = 'public/images/icons/' . $imageName;
        }

        if ($request->hasFile('dark_image_path')) {
            $darkImage = $request->file('dark_image_path');
            $darkImageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $darkImageName = Str::slug($imageName) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $darkImage->move(public_path('images/icons'), $darkImageName);
            $darkImagePath = 'public/images/icons/' . $darkImageName;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'dark_image_path' => $darkImagePath,
            'icon_class' => $validated['icon_class'] ?? null,
            'dark_icon_class' => $validated['dark_icon_class'] ?? null,
        ]);

        return redirect()->route('admin.categories.view')->with('success', 'Category added.');
    }

    public function getCategoriesData(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::withTrashed()->select(['id', 'name', 'slug', 'image_path', 'dark_image_path', 'icon_class', 'dark_icon_class', 'description', 'created_at', 'updated_at', 'deleted_at']);

            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    $images = '';
                    if ($row->image_path) {
                        $images .= '<img src="' . asset($row->image_path) . '" alt="Image" style="background-color:black;" width="24" height="24" class="me-2">';
                    }
                    if ($row->dark_image_path) {
                        $images .= '<img src="' . asset($row->dark_image_path) . '" alt="Dark Image" width="24" height="24">';
                    }
                    return $images ?: '—';
                })
                ->addColumn('icon', function ($row) {
                    $icons = '';
                    if ($row->icon_class) {
                        $icons .= '<i class="' . e($row->icon_class) . ' me-2"></i>';
                    }
                    if ($row->dark_icon_class) {
                        $icons .= '<i class="' . e($row->dark_icon_class) . '"></i>';
                    }
                    return $icons ?: '—';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.categories.edit', $row->id);
                    $deleteUrl = route('admin.categories.delete', $row->id);
                    $restoreUrl = route('admin.categories.restore', $row->id);
                    if ($row->deleted_at) {
                        return '
                            <a href="#" class="text-success btn-restore d-block text-center" data-url="' . $restoreUrl . '" title="Enable">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>';
                    } else {
                        return '
                            <a href="' . $editUrl . '" class="text-primary pe-2" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="#" class="text-danger btn-delete" data-url="' . $deleteUrl . '" title="Delete">
                                <i class="bi bi-trash"></i>
                            </a>';
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i') : '';
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('Y-m-d H:i') : '';
                })
                ->setRowClass(function ($row) {
                    return $row->deleted_at ? 'table-secondary text-muted' : '';
                })
                ->rawColumns(['action', 'image', 'icon'])
                ->make(true);
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:webp|max:2048',
            'dark_image_path' => 'nullable|image|mimes:webp|max:2048',
            'icon_class' => 'nullable|string|max:255',
            'dark_icon_class' => 'nullable|string|max:255',
        ]);

        $category = Category::findOrFail($id);

        $slug = Str::slug($request->name);

        if (
            Category::withTrashed()
                ->where('slug', $slug)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            throw ValidationException::withMessages([
                'name' => ['The generated slug "' . $slug . '" already exists. Please choose a different name.'],
            ]);
        }

        if ($request->filled('delete_image') && $category->image_path) {
            File::delete(public_path($category->image_path));
            $category->image_path = null;
        }

        // Delete dark image if checkbox is selected
        if ($request->filled('delete_dark_image') && $category->dark_image_path) {
            File::delete(public_path($category->dark_image_path));
            $category->dark_image_path = null;
        }

        $targetDir = public_path('images/icons');

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = Str::slug($imageName) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($targetDir, $imageName);
            $category->image_path = 'public/images/icons/' . $imageName;
        }

        if ($request->hasFile('dark_image_path')) {
            $darkImage = $request->file('dark_image_path');
            $darkImageName = pathinfo($darkImage->getClientOriginalName(), PATHINFO_FILENAME);
            $darkImageName = Str::slug($darkImageName) . '-' . time() . '.' . $darkImage->getClientOriginalExtension();
            $darkImage->move($targetDir, $darkImageName);
            $category->dark_image_path = 'public/images/icons/' . $darkImageName;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->description = $request->description;
        $category->icon_class = $request->icon_class;
        $category->dark_icon_class = $request->dark_icon_class;
        $category->save();

        return redirect()->route('admin.categories.view')->with('success', 'Category updated successfully.');
    }

    public function softDeleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }

    public function restoreCategory($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return response()->json(['success' => true, 'message' => 'Category restored successfully.']);
    }

    public function productsIndex()
    {
        return view('admin.products.index');
    }

    public function createProduct()
    {
        $categories = Category::all('name', 'id');
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image_path' => 'nullable|image|mimes:webp|max:2048',
        ]);

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;

        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/images/img'), $imageName);
            $validated['image_path'] = 'public/images/img/' . $imageName;
        }

        Product::create([
            ...$validated,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.products.view')->with('success', 'Product added.');
    }

    public function getProductsData(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::withTrashed()->select([
                'id',
                'category_id',
                'name',
                'slug',
                'description',
                'price',
                'stock',
                'image_path',
                'created_at',
                'updated_at',
                'deleted_at'
            ]);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.products.edit', $row->id);
                    $deleteUrl = route('admin.products.delete', $row->id);
                    $restoreUrl = route('admin.products.restore', $row->id);
                    if ($row->deleted_at) {
                        return '
                            <a href="' . $editUrl . '" class="text-muted me-2" title="Edit (Disabled)">
                                <i class="bi bi-pencil" style="pointer-events: none;"></i>
                            </a>
                            <a href="#" class="text-success btn-restore" data-url="' . $restoreUrl . '" title="Enable">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>';
                    } else {
                        return '
                            <a href="' . $editUrl . '" class="text-primary me-2" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="#" class="text-danger btn-delete" data-url="' . $deleteUrl . '" title="Delete">
                                <i class="bi bi-trash"></i>
                            </a>';
                    }
                })
                ->addColumn('category', function ($row) {
                    return $row->category ? $row->category->name : '<span class="text-muted">None</span>';
                })
                ->addColumn('image', function ($row) {
                    if ($row->image_path) {
                        return '<img src="' . asset($row->image_path) . '" alt="Product Image" height="40">';
                    } else {
                        return '<span class="text-muted">No Image</span>';
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i') : '';
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('Y-m-d H:i') : '';
                })
                ->setRowClass(function ($row) {
                    return $row->deleted_at ? 'table-secondary text-muted' : ''; // greyed-out class for soft-deleted
                })
                ->rawColumns(['action', 'category', 'image'])
                ->make(true);
        }
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all('name', 'id');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image_path' => 'nullable|image|mimes:webp|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $product = Product::findOrFail($id);

        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;

        while (
            Product::withTrashed()
                ->where('slug', $slug)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        if ($request->has('delete_image') && $product->image_path) {
            if (file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }
            $product->image_path = null;
        }

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/img'), $imageName);
            $validated['image_path'] = 'public/images/img/' . $imageName;
        } else {
            unset($validated['image_path']);
        }

        $product->update([
            ...$validated,
            'slug' => $slug,
        ]);

        return redirect()->route('admin.products.view')->with('success', 'Product updated successfully.');
    }

    public function softDeleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }

    public function restoreProduct($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return response()->json(['success' => true, 'message' => 'Product restored successfully.']);
    }
}
