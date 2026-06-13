<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('storefront.pages.show', compact('page'));
    }

    public function faq(): View
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('storefront.pages.faq', compact('faqs'));
    }
}
