<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Departement; // ✅ Avec 'e'
use App\Models\Position;   // ✅

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
{
     $user = $request->user()->load(['position', 'departement']);
    // OU selon le nom de ton modèle
    // $user = $request->user()->load(['position', 'departement']);
    
    $posts = $user->posts()
        ->latest()
        ->withCount(['likes', 'comments'])
        ->get();

    return view('profile.show', compact('user', 'posts'));
}
   public function edit(Request $request)
{
    // ✅ Charge aussi les relations ici pour pré-remplir le formulaire
    $user = $request->user()->load(['position', 'departement']);
    
    $departements = \App\Models\Departement::where('is_active', true)
        ->orderBy('name')
        ->get();
    
    $positions = \App\Models\Position::where('is_active', true)
        ->orderBy('title')
        ->get();
    
    return view('profile.edit', compact('user', 'departements', 'positions'));
}

   public function update(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'position_id' => ['nullable', 'exists:positions,id'],
        'departement_id' => ['nullable', 'exists:departements,id'],
        'phone' => ['nullable', 'string', 'max:50'],
        'location' => ['nullable', 'string', 'max:255'],
        'bio' => ['nullable', 'string', 'max:2000'],
        'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ]);


    if ($request->hasFile('avatar')) {
        // Supprimer l'ancien avatar s'il existe
        if ($user->avatar_path) {
            Storage::delete('public/' . $user->avatar_path);
        }
        
        // Stocker le nouveau avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $validated['avatar_path'] = $path;
    }

    $user->update($validated);

    // ✅ Vérifie après la sauvegarde

    return redirect()
        ->route('profile.show')
        ->with('success', 'Profil mis à jour.');
}
}