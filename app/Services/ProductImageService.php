<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Upload and store multiple images for a product.
     */
    public function uploadImages(Product $product, array $images): void
    {
        // Get the current max sort order
        $maxSortOrder = $product->images()->max('sort_order') ?? -1;
        $isFirstImage = $maxSortOrder === -1;

        foreach ($images as $index => $image) {
            if (!$image->isValid()) {
                continue;
            }

            $path = $image->store('products', 'public');

            $product->images()->create([
                'path' => $path,
                'sort_order' => $maxSortOrder + $index + 1,
                // Make the very first uploaded image primary automatically
                'is_primary' => $isFirstImage && $index === 0,
            ]);
        }
    }

    /**
     * Delete an image file and its database record.
     */
    public function deleteImage(ProductImage $image): void
    {
        // Delete from storage
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // Check if we need to assign a new primary image
        $wasPrimary = $image->is_primary;
        $productId = $image->product_id;
        
        $image->delete();

        if ($wasPrimary) {
            $newPrimary = ProductImage::where('product_id', $productId)
                ->orderBy('sort_order')
                ->first();
                
            if ($newPrimary) {
                $newPrimary->update(['is_primary' => true]);
            }
        }
    }

    /**
     * Set a specific image as the primary image for a product.
     */
    public function setPrimary(Product $product, ProductImage $newPrimaryImage): void
    {
        if ($newPrimaryImage->product_id !== $product->id) {
            throw new \InvalidArgumentException('Image does not belong to this product.');
        }

        // Unset current primary
        $product->images()->where('is_primary', true)->update(['is_primary' => false]);

        // Set new primary
        $newPrimaryImage->update(['is_primary' => true]);
    }
}
