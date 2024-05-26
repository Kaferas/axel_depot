@extends('layouts.template')

@section('header_title')
    Modifier Categorie
@endsection

@section('content')
    <div class="container card m-3 p-3">
        <h3>Modifier Categorie</h3>
    </div>
    <div class="card mt-3">
        <form action="{{ route('categories.update', $categorie) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row p-2">
                <div class="form-group col-5">
                    <label for="">Nom Categorie:</label>
                    <input type="text" name="nom_categorie" id="" class="form-control"
                        value='{{ empty($categorie->nom_categorie) ? old('nom_categorie') : $categorie->nom_categorie }}'>
                    @if ($errors->has('nom_categorie'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('nom_categorie') }}</div>
                    @endif
                </div>
                <div class="col-5 form-group">
                    <label for="">Couleur Categorie:</label>
                    <input type="color" name="color_categorie" id="" class="form-control"
                        value='{{ empty($categorie->color_categorie) ? old('color_categorie') : $categorie->color_categorie }}'>
                    @if ($errors->has('color_categorie'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('color_categorie') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group p-2">
                <button type="submit" class="btn btn-warning">Modification</button>
            </div>
        </form>
    </div>
@endsection
