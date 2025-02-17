@extends('layouts.app')

@section('title', 'Modifier un poney')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Modifier un Poney</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{route('pony.update', $pony->id)}}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du poney</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control" 
                        value="{{ old('name', $pony->name) }}" 
                        required>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{route('pony.index')}}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection