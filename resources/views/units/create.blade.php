@extends('layouts.template')
@section('header_title')
    Creation Unite de Mesure
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                            <h4 class="header-title">Nouveau Unite de Mesure</h4>

                        </div>
                        <div class="col-8">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">PAEEJ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('units.index') }}">Units</a>
                                        </li>
                                        <li class="breadcrumb-item active">Nouveau Unite</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('units.store') }}">
                        @csrf()
                        <div class="row mt-2 mb-2">
                            <div class="mb-3 col-12">
                                <label class="form-label" for="name_unit">Nom Unite Mesure</label>
                                <input type="text" class="form-control" id="name_unit" placeholder="Unite 1"
                                    value="{{ old('name_unit') }}" name="name_unit">
                                @error('name_unit')
                                    <div class="mt-2 alert alert-warning text-bg-info bg-warning border-0 fade show">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label class="form-label" for="codebar">Description Unite</label>
                                <textarea name="description_unit" id="description_unit" cols="30" rows="5" class="form form-control"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Enregistrer Unite Mesure</button>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

    </div>
@endsection
