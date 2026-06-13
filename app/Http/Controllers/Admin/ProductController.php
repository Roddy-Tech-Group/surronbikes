<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ProductImageService $imageService)
    {
    }

    public function index(Request $request): View
    {
        $products = Product::with(['category', 'primaryImage'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $validated['featured'] = $request->boolean('featured');
            
            // Format specifications to array format if it exists
            if (isset($validated['specifications'])) {
                // Remove empty specs
                $validated['specifications'] = array_filter($validated['specifications'], function($spec) {
                    return !empty($spec['name']) && !empty($spec['value']);
                });
                // Reindex array so it's a clean JSON array
                $validated['specifications'] = array_values($validated['specifications']);
            }

            $product = Product::create($validated);

            if ($request->hasFile('images')) {
                $this->imageService->uploadImages($product, $request->file('images'));
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating product: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $validated['featured'] = $request->boolean('featured');
            
            // Format specifications to array format if it exists
            if (isset($validated['specifications'])) {
                $validated['specifications'] = array_filter($validated['specifications'], function($spec) {
                    return !empty($spec['name']) && !empty($spec['value']);
                });
                $validated['specifications'] = array_values($validated['specifications']);
            } else {
                $validated['specifications'] = [];
            }

            $product->update($validated);

            if ($request->hasFile('images')) {
                $this->imageService->uploadImages($product, $request->file('images'));
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating product: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            // Delete all images from storage first
            foreach ($product->images as $image) {
                $this->imageService->deleteImage($image);
            }
            
            $product->delete();
            
            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    public function deleteImage(Product $product, ProductImage $image): RedirectResponse
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        $this->imageService->deleteImage($image);

        return back()->with('success', 'Image deleted successfully.');
    }

    public function setPrimary(Product $product, ProductImage $image): RedirectResponse
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        $this->imageService->setPrimary($product, $image);

        return back()->with('success', 'Primary image updated.');
    }
}
