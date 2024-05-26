@extends('layouts.template')

@section('header_title')
    Creation Categorie
@endsection

@section('content')
    <div class="container card m-3 p-3">
        <h3>Nouveau Categorie</h3>
    </div>
    <div class="card mt-3">
        <form action="{{ route('categories.store') }}" method="post">
            @csrf
            <div class="row p-2">
                <div class="form-group col-5">
                    <label for="">Nom Categorie:</label>
                    <input type="text" name="nom_categorie" id="" class="form-control"
                        value='{{ old('nom_categorie') }}'>
                    @if ($errors->has('nom_categorie'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('nom_categorie') }}</div>
                    @endif
                </div>
                <div class="col-5 form-group">
                    <label for="">Couleur Categorie:</label>
                    <input type="color" name="color_categorie" id="" class="form-control"
                        value='{{ old('color_categorie') }}'>
                    @if ($errors->has('color_categorie'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('color_categorie') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group p-2">
                <button type="submit" class="btn btn-info">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
