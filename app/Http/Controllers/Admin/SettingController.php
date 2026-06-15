<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Company Info
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:50',
            'company_address' => 'nullable|string|max:500',
            
            // Branding
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            
            // About Us
            'about_us_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'about_us_story_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            
            // Social Links
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_tiktok' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
        ]);

        // Handle Logo Upload separately
        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo_path');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            $path = $request->file('logo')->store('settings', 'public');
            Setting::set('logo_path', $path);
        }

        // Handle Logo Deletion
        if ($request->boolean('delete_logo')) {
            $oldLogo = Setting::get('logo_path');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            Setting::set('logo_path', null);
        }

        // Handle About Us Image Upload
        if ($request->hasFile('about_us_image')) {
            $oldAboutImage = Setting::get('about_us_image_path');
            if ($oldAboutImage && Storage::disk('public')->exists($oldAboutImage)) {
                Storage::disk('public')->delete($oldAboutImage);
            }
            
            $path = $request->file('about_us_image')->store('settings', 'public');
            Setting::set('about_us_image_path', $path);
        }

        // Handle About Us Image Deletion
        if ($request->boolean('delete_about_us_image')) {
            $oldAboutImage = Setting::get('about_us_image_path');
            if ($oldAboutImage && Storage::disk('public')->exists($oldAboutImage)) {
                Storage::disk('public')->delete($oldAboutImage);
            }
            Setting::set('about_us_image_path', null);
        }

        // Handle About Us Story Image Upload
        if ($request->hasFile('about_us_story_image')) {
            $oldStoryImage = Setting::get('about_us_story_image_path');
            if ($oldStoryImage && Storage::disk('public')->exists($oldStoryImage)) {
                Storage::disk('public')->delete($oldStoryImage);
            }
            
            $path = $request->file('about_us_story_image')->store('settings', 'public');
            Setting::set('about_us_story_image_path', $path);
        }

        // Handle About Us Story Image Deletion
        if ($request->boolean('delete_about_us_story_image')) {
            $oldStoryImage = Setting::get('about_us_story_image_path');
            if ($oldStoryImage && Storage::disk('public')->exists($oldStoryImage)) {
                Storage::disk('public')->delete($oldStoryImage);
            }
            Setting::set('about_us_story_image_path', null);
        }

        // Save other settings
        $keys = [
            'company_name', 'company_email', 'company_phone', 'company_address',
            'social_facebook', 'social_instagram', 'social_tiktok', 'social_youtube', 'social_twitter'
        ];

        foreach ($keys as $key) {
            if (array_key_exists($key, $validated)) {
                Setting::set($key, $validated[$key]);
            }
        }

        // Clear settings cache if any was implemented (e.g. Setting::get() uses cache)
        Cache::forget('settings_all');

        return back()->with('success', 'Settings have been successfully updated.');
    }
}
