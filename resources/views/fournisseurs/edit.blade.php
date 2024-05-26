@extends('layouts.template')

@section('header_title')
    Modification Fournisseur
@endsection

@section('content')
    <div class="container card m-3 p-3">
        <h3>Modification Fournisseur</h3>
    </div>
    <div class="card mt-3">
        <form action="{{ route('fournisseurs.update', $fournisseur) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row p-2">
                <div class="form-group col-5">
                    <label for="">Nom Fournisseurs:</label>
                    <input type="text" name="nom_fournisseur" id="" class="form-control"
                        value='{{ empty($fournisseur->nom_fournisseur) ? old('nom_fournisseur') : $fournisseur->nom_fournisseur }}'>
                    @if ($errors->has('nom_fournisseur'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('nom_fournisseur') }}</div>
                    @endif
                </div>
                <div class="col-5 form-group">
                    <label for="">Prenom:</label>
                    <input type="text" name="prenom_fournisseur" id="" class="form-control"
                        value='{{ empty($fournisseur->prenom_fournisseur) ? old('prenom_fournisseur') : $fournisseur->prenom_fournisseur }}'>
                    @if ($errors->has('prenom_fournisseur'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('prenom_fournisseur') }}</div>
                    @endif
                </div>
            </div>
            <div class="row p-2">
                <div class="form-group col-12">
                    <label for="">Telephone:</label>
                    <input type="number" name="telephone" id="" class="form-control"
                        value="{{ empty($fournisseur->telephone) ? old('telephone') : $fournisseur->telephone }}" />
                    @if ($errors->has('telephone'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('telephone') }}</div>
                    @endif
                </div>
            </div>
            <div class="row p-2">
                <div class="col-5 form-group">
                    <label for="">Boite Postal:</label>
                    <input type="text" name="boite_postal" id="" class="form-control"
                        value='{{ empty($fournisseur->boite_postal) ? old('boite_postal') : $fournisseur->boite_postal }}'>
                </div>
                <div class="col-5 form-group">
                    <label for="">Email:</label>
                    <input type="text" name="email" id="" class="form-control"
                        value='{{ empty($fournisseur->email) ? old('email') : $fournisseur->email }}'>
                </div>
            </div>
            <div class="form-group p-2">
                <button type="submit" class="btn btn-warning">Modification</button>
            </div>
        </form>
    </div>
@endsection
