<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    private function formatStat($number): string
    {
        if ($number >= 1000) {
            return rtrim(rtrim(number_format($number / 1000, 1), '0'), '.') . 'k+';
        }
        if ($number >= 100) {
            return (floor($number / 100) * 100) . '+';
        }
        if ($number >= 50) {
            return '50+';
        }
        if ($number >= 10) {
            return '10+';
        }
        return (string) $number;
    }

    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        $data = ['page' => $page];

        if ($slug === 'about-us') {
            $data['testimonials'] = \App\Models\Testimonial::where('is_active', true)->latest()->take(6)->get();
            
            $productCount = 2000 + \App\Models\Product::count();
            $orderCount = 150 + \App\Models\Order::revenue()->count();
            $categoryCount = \App\Models\Category::count();
            $years = max(1, date('Y') - 2020);

            $data['stats'] = [
                'products' => $this->formatStat($productCount),
                'orders' => $this->formatStat($orderCount),
                'categories' => $this->formatStat($categoryCount),
                'years' => $years . '+',
            ];
        }

        return view('storefront.pages.show', $data);
    }

    public function faq(): View
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('storefront.pages.faq', compact('faqs'));
    }

    public function storeTestimonial(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|max:4096',
        ]);

        $data['is_active'] = false;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('testimonials', 'public');
        }

        \App\Models\Testimonial::create($data);

        return back()->with('success', 'Thank you for your review! It will be published once approved.');
    }
}
