@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des utilisateurs</h1>
    <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">Ajouter un utilisateur</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-primary me-2">Modifier</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
