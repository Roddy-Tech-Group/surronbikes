<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($testimonial->image_path && Storage::disk('public')->exists($testimonial->image_path)) {
                Storage::disk('public')->delete($testimonial->image_path);
            }
            $data['image_path'] = $request->file('image')->store('testimonials', 'public');
        } elseif ($request->boolean('delete_image')) {
            if ($testimonial->image_path && Storage::disk('public')->exists($testimonial->image_path)) {
                Storage::disk('public')->delete($testimonial->image_path);
            }
            $data['image_path'] = null;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        if ($testimonial->image_path && Storage::disk('public')->exists($testimonial->image_path)) {
            Storage::disk('public')->delete($testimonial->image_path);
        }
        
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
