<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $admins = Admin::orderBy('name')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create(): View
    {
        return view('admin.admins.create');
    }

    public function store(AdminRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        
        Admin::create($validated);
        
        return redirect()->route('admin.admins.index')->with('success', 'Admin account created successfully.');
    }

    public function edit(Admin $admin): View
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(AdminRequest $request, Admin $admin): RedirectResponse
    {
        $validated = $request->validated();

        // Safeguard: Prevent deactivating yourself
        if (Auth::guard('admin')->id() === $admin->id && empty($validated['is_active'])) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        // Safeguard: Prevent deactivating the last active admin
        if (empty($validated['is_active'])) {
            $activeCount = Admin::where('is_active', true)->where('id', '!=', $admin->id)->count();
            if ($activeCount === 0) {
                return back()->with('error', 'You cannot deactivate this account because it is the only active admin remaining.');
            }
        }

        $admin->update($validated);
        
        return redirect()->route('admin.admins.index')->with('success', 'Admin account updated successfully.');
    }

    public function editPassword(Admin $admin): View
    {
        return view('admin.admins.password', compact('admin'));
    }

    public function updatePassword(Request $request, Admin $admin): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('admin.admins.index')->with('success', "Password for {$admin->name} has been updated.");
    }

    public function destroy(Admin $admin): RedirectResponse
    {
        // Safeguard: Prevent deleting yourself
        if (Auth::guard('admin')->id() === $admin->id) {
            return back()->with('error', 'You cannot delete your own account while logged in.');
        }

        // Safeguard: Prevent deleting the last active admin
        if ($admin->is_active) {
            $activeCount = Admin::where('is_active', true)->where('id', '!=', $admin->id)->count();
            if ($activeCount === 0) {
                return back()->with('error', 'You cannot delete this account because it is the only active admin remaining.');
            }
        }

        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'Admin account deleted successfully.');
    }
}
