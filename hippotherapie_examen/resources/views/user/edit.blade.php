@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Modifier un Utilisateur</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{route('user.update', $user->id)}}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'utilisateur</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control" 
                        value="{{ old('name', $user->name) }}" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        value="{{ old('email', $user->email) }}" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Rôle</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="" disabled selected>Sélectionnez un rôle</option>
                        @foreach($roles as $value => $label)
                        <option value="{{ $value }}" 
                            {{ $value == old('role', $user->role) ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        >
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{route('user.index')}}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection