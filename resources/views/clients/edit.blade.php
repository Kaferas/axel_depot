@extends('layouts.template')

@section('header_title')
    Creation Clients
@endsection

@section('content')
    <div class="container card m-3 p-3">
        <h3>Nouveau Clients</h3>
    </div>
    <div class="card mt-3">
        <form action="{{ route('clients.update', $client) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row p-2">
                <div class="form-group col-5">
                    <label for="">Nom Clients:</label>
                    <input type="text" name="name_client" id="" class="form-control"
                        value='{{ empty($client->name_client) ? old('name_client') : $client->name_client }}'>
                    @if ($errors->has('name_client'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('name_client') }}</div>
                    @endif
                </div>
                <div class="col-5 form-group">
                    <label for="">Prenom Clients:</label>
                    <input type="text" name="prenom_client" id="" class="form-control"
                        value='{{ empty($client->prenom_client) ? old('prenom_client') : $client->prenom_client }}'>
                    @if ($errors->has('prenom_client'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('prenom_client') }}</div>
                    @endif
                </div>
            </div>
            <div class="row p-2">
                <div class="form-group col-6">
                    <label for="">Telephone Client:</label>
                    <input type="number" name="phone_client" id="" class="form-control"
                        value="{{ empty($client->phone_client) ? old('phone_client') : $client->phone_client }}" />
                    @if ($errors->has('phone_client'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('phone_client') }}</div>
                    @endif
                </div>
                <div class="form-group col-6">
                    <label for="">Adresse Client:</label>
                    <input type="text" name="adresse_client" id="" class="form-control"
                        value="{{ empty($client->adresse_client) ? old('adresse_client') : $client->adresse_client }}" />
                    @if ($errors->has('adresse_client'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('adresse_client') }}</div>
                    @endif
                </div>
            </div>
            <div class="row p-2">
                <div class="col-12 form-group">
                    <label for="">NIF Client:</label>
                    <input type="text" name="nif_client" id="" class="form-control"
                        value='{{ empty($client->nif_client) ? old('nif_client') : $client->nif_client }}'>
                </div>
            </div>
            <div class="form-group p-2">
                <button type="submit" class="btn btn-warning">Modification</button>
            </div>
        </form>
    </div>
@endsection
