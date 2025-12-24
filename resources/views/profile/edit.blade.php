@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Modifier mon profil</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Poste</label>
                <input class="form-control" name="job_title" value="{{ old('job_title', $user->job_title) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Département</label>
                <input class="form-control" name="department" value="{{ old('department', $user->department) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Téléphone</label>
                <input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Localisation</label>
                <input class="form-control" name="location" value="{{ old('location', $user->location) }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea class="form-control" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="mb-3">
    <label class="form-label">Photo de profil</label>
    <input type="file"
           name="avatar"
           class="form-control"
           accept="image/*">
    <div class="form-text">PNG, JPG, WEBP – max 2MB</div>
</div>



        <button class="btn btn-success">Enregistrer</button>
        <a class="btn btn-outline-secondary" href="{{ route('profile.show') }}">Annuler</a>
    </form>
</div>
@endsection
