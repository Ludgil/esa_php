@extends('layouts.app')

@section('title', 'Ajouter un poney')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ajouter un nouveau poney</h4>
    </div>
    <div class="card-body">
        <form action="{{route("pony.store")}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nom du poney</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nom" required>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="{{route('pony.index')}}" class="btn btn-primary">Retour</a>
        </form>
    </div>
</div>
@endsection