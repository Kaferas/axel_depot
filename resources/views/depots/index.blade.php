@extends('layouts.template')

@section('header_title')
    Listes des Depots
@endsection

@section('content')
    <div class="container card m-3 p-3  ">
        <h3>Listes des Depots</h3>

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
                    <a href="{{ route('depots.create') }}" class="btn btn-primary"><i class="ri-add-fill"></i></a>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Localite</th>
                <th>Gerant</th>
                <th>Telephone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($depots as $i => $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->nom_depot }}</td>
                    <td>{{ $item->localite }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->telephone }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('depots.edit', $item) }}"><i
                                class="ri-pencil-line"></i></a>
                        <a class="btn btn-sm btn-danger"><i class="ri-eraser-fill"></i></a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
