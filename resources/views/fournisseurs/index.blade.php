@extends('layouts.template')

@section('header_title')
    Listes des Fournisseurs
@endsection

@section('content')
    <div class="container card m-3 p-3  ">
        <h3>Listes des Fournisseurs</h3>

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
                    <a href="{{ route('fournisseurs.create') }}" class="btn btn-primary"><i class="ri-add-fill"></i></a>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Telephone</th>
                <th>BP</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fournisseurs as $i => $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->nom_fournisseur }}</td>
                    <td>{{ $item->prenom_fournisseur }}</td>
                    <td>{{ $item->telephone }}</td>
                    <td>{{ $item->boite_postal }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('fournisseurs.edit', $item) }}"><i
                                class="ri-pencil-line"></i></a>
                        <form class="d-inline-block" action="{{ route('fournisseurs.destroy', $item) }}" method="post">
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
