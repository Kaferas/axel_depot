@extends('layouts.template')

@section('header_title')
    Listes des Articles
@endsection

@section('content')
    <div class="container card m-3 p-3  ">
        <h3>Listes des Articles</h3>
        <form action="" class="col-12 d-flex align-items-center">
            <div class="form-group col-8">
                <label for="" class="text text-info">Search:</label>
                <input type="text" name="" class="form-control" id="" placeholder="Votre Recherche Ici...">
            </div>
            <div class="col-1"></div>
            <div class="form-group col-1 mt-3">
                <button type="submit" class="btn btn-info">Chercher</button>
            </div>
            <div class="col-1"></div>
            <div class="col-2">
                <div class="form-group mt-3">
                    <a href="{{ route('articles.create') }}" class="btn btn-primary"><i class="ri-add-fill"></i></a>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>CodeBarre</th>
                <th>Nom</th>
                <th>Categorie</th>
                <th>Prix Achat</th>
                <th>Prix Vente</th>
                <th>Unite Mesure</th>
                <th>Quantite</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $i => $item)
                <tr>
                    <td>{{ $item->codebar_article }}</td>
                    <td>{{ $item->article_name }}</td>
                    <td><i class="p-2"
                            style="background-color:{{ $item->color_categorie }}"></i>&nbsp;{{ $item->nom_categorie }}
                    </td>
                    <td>{{ $item->price_achat }} FBU</td>
                    <td>{{ $item->price_vente }} FBU</td>
                    <td>{{ $item->unite_mesure }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>
                        <a href="{{ route('articles.edit', $item->id) }}" class="btn btn-sm btn-info"><i
                                class="ri-pencil-line"></i></a>
                        <form class="d-inline-block" action="{{ route('articles.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button onclick="confirm('Voulez-vous Executer l\'action?')"
                                class="btn btn-danger btn-sm text-light"><i class="ri-eraser-fill"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
