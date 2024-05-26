@extends('layouts.template')

@section('header_title')
    Creation Depot
@endsection

@section('content')
    <div class="container card m-3 p-3">
        <h3>Nouveau Depot</h3>
    </div>
    <div class="card mt-3">
        <form action="{{ route('depots.store') }}" method="post">
            @csrf
            <div class="row p-2">
                <div class="form-group col-5">
                    <label for="">Nom Depot:</label>
                    <input type="text" name="nom_depot" id="" class="form-control" value='{{ old('nom_depot') }}'>
                    @if ($errors->has('nom_depot'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('nom_depot') }}</div>
                    @endif
                </div>
                <div class="col-5 form-group">
                    <label for="">Localite:</label>
                    <input type="text" name="localite" id="" class="form-control" value='{{ old('localite') }}'>
                    @if ($errors->has('localite'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('localite') }}</div>
                    @endif
                </div>
            </div>
            <div class="row p-2">
                <div class="form-group col-5">
                    <label for="">Gerant:</label>
                    <select name="gerant_id" id="" class="form-control">
                        <option value="">Choisissez Gerant</option>
                        @foreach ($gerants as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('gerant_id'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('gerant_id') }}</div>
                    @endif
                </div>
                <div class="col-5 form-group">
                    <label for="">Telephone:</label>
                    <input type="text" name="telephone" id="" class="form-control"
                        value='{{ old('telephone') }}'>
                    @if ($errors->has('telephone'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('telephone') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group p-2">
                <button type="submit" class="btn btn-info">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
