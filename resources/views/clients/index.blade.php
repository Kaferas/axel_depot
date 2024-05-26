@extends('layouts.template')

@section('header_title')
    Listes des clients
@endsection

@section('content')
    <div class="container card m-3 p-3  ">
        <h3>Listes des Clients</h3>
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
                    <a href="{{ route('clients.create') }}" class="btn btn-primary"><i class="ri-add-fill"></i></a>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Client</th>
                <th>Prenom Client</th>
                <th>Phone </th>
                <th>NIF Client</th>
                <th>Adresse</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $i => $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->name_client }}</td>
                    <td>{{ $item->prenom_client }}</td>
                    <td>{{ $item->phone_client }}</td>
                    <td>{{ $item->nif_client }}</td>
                    <td>{{ $item->adresse_client }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{ route('clients.edit', $item) }}"><i
                                class="ri-pencil-line"></i></a>
                        <form class="d-inline-block" action="{{ route('clients.destroy', $item) }}" method="post">
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
