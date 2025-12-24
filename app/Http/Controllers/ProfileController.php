<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
{
    $user = $request->user(); // 👈 IDE-friendly

    $posts = $user->posts()
        ->latest()
        ->withCount(['likes', 'comments'])
        ->get();

    return view('profile.show', compact('user', 'posts'));
}


    public function edit(Request $request)
{
    $user = $request->user(); // ✅ typé, IDE content
    return view('profile.edit', compact('user'));
}


    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Upload avatar
        if ($request->hasFile('avatar')) {
            // Supprimer ancienne photo
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil mis à jour.');
    }
}
