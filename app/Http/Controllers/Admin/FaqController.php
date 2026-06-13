<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        $nextOrder = Faq::max('sort_order') + 1;
        return view('admin.faqs.create', compact('nextOrder'));
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        Faq::create($request->validated());
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ has been created.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validated());
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ has been updated.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ has been deleted.');
    }
}
