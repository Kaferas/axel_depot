@extends('layouts.template')

@section('header_title')
    Ajouter Articles
@endsection

@section('content')
    <form action="{{ route('articles.store') }}" method="POST" class="card p-3 m-3">
        <h3 class="p-3">Ajouter Article</h3>
        @csrf
        <div class="row mt-4">
            <div class="form-group col-4">
                <label for="">Nom Article:</label>
                <input type="text" class="form-control" name="article_name" id=""
                    value="{{ old('article_name') }}">
                @if ($errors->has('article_name'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('article_name') }}</div>
                @endif
            </div>
            <div class="form-group col-4">
                <label for="">Categorie Article:</label>
                <select name="categorie_id" id="" class="form-control">
                    <option value="">Choisissez Categories</option>
                    @foreach ($categories as $item)
                        <option {{ old('categorie_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                            {{ $item->nom_categorie }}</option>
                    @endforeach
                </select>
                @if ($errors->has('categorie_id'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('categorie_id') }}</div>
                @endif
            </div>
            <div class="form-group col-4">
                <label for="">Prix d'AChat:</label>
                <input type="text" class="form-control" name="price_achat" id=""
                    value="{{ old('price_achat') }}">
                @if ($errors->has('price_achat'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('price_achat') }}</div>
                @endif
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group col-4">
                <label for="">Prix de Vente:</label>
                <input type="text" class="form-control" name="price_vente" id=""
                    value="{{ old('price_vente') }}">
                @if ($errors->has('price_vente'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('price_vente') }}</div>
                @endif
            </div>
            <div class="form-group col-4">
                <label for="">Unite de Mesure:</label>
                <input type="text" name="unite_mesure" id="" class="form-control"
                    value="{{ old('unite_mesure') }}" />
                @if ($errors->has('unite_mesure'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('unite_mesure') }}</div>
                @endif
            </div>
            <div class="col-4 form-group">
                <label for="">CodeBarre:</label>
                <input type="text" readonly class="form-control" name="codebar_article" value="{{ $code }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group col-4 mt-2">
                <button type="submit" class="col-6 btn btn-info">Enregistrer</button>
            </div>
        </div>
    </form>
@endsection
