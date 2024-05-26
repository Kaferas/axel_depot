@extends('layouts.template')
@section('header_title')
    Inventaires Listes
@endsection
@section('content')
    <div class="row mt-2 card p-1">

        <div class="card ">
            <form action="{{ route('inventaires.index') }}" method="get" class="d-flex justify-content-between">
                @csrf
                <div class="row col-10 d-flex justify-content-center">
                    <div class="mb-3 col-3">
                        <label for="example-date" class="form-label">Du:</label>
                        <input class="form-control d-inline-block" id="example-date" type="date" name="from_date"
                            value="{{ old('from_date') }}">
                    </div>
                    <div class="mb-3 col-3">
                        <label for="example-date" class="form-label">Au:</label>
                        <input class="d-inline-block form-control" id="example-date" type="date" name="to_date"
                            value="{{ old('to_date') }}">
                    </div>
                    <div class="mb-3 col-5">
                        <label for="example-date" class="form-label">Search:</label>
                        <input type="text" placeholder="Rechercher Icii..." name="searchKey" id="searchKey"
                            class="form-control" value="{{ $search }}">
                    </div>
                </div>
                <div class="mt-3 col-3">
                    <button type="submit" class="d-inline-block btn btn-xs btn-primary"><i
                            class="ri-search-line"></i></button>
                    <a href="{{ route('inventaires.index') }}" type="reset"
                        class="d-inline-block btn btn-xs btn-secondary"><i class="ri-reply-line"
                            title="Reinitialiser"></i></a>
                    <a href="{{ route('inventaires.create') }}" class="d-inline-block btn btn-xs btn-info"
                        title="Ajouter Nouveu Inventaire"><i class="text text-light ri-add-box-line"></i></a>
                </div>
            </form>
        </div>
        <div class="card p-3">
            <table id="tech-companies-1" class="table table-striped">
                <thead>
                    <tr>
                        <th data-priority="1">Nom</th>
                        <th data-priority="1">Code Inventaire</th>
                        <th data-priority="3" class="text-center">Auteur</th>
                        <th data-priority="3" class="text-center">Date Creation</th>
                        <th data-priority="3" class="text-center">Status</th>
                        <th data-priorty="6" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventaires as $item)
                        <?php
                        $colorc;
                        $status;
                        if ($item->global_status == 0) {
                            $status = 'En Attente';
                            $colorc = 'text text-warning';
                        } else {
                            $status = 'Confirmé';
                            $colorc = 'text text-info';
                        }
                        
                        ?>
                        <tr>
                            <td class="col-3"><b>{{ $item->title_inventory }}</b></td>
                            <td><b>{{ $item->inventory_code }}</b></td>
                            <td class="text-center">{{ $item->name }}</td>
                            <td class="text-center">{{ $item->created_at }}</td>
                            <td class="text-center {{ $colorc }}">{{ $status }}</td>
                            <td class="text text-center">
                                <a href="{{ route('inventaires.show', $item->id) }}"
                                    title="Voir: {{ $item->title_inventory }}" class="btn btn-sm btn-success"><i
                                        class="ri-eye-line"></i>
                                </a>

                                <button onclick="deleteArticle({{ $item->id }})"
                                    title="Supprimer: {{ $item->title_inventory }}" class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#info-header-modal"><i
                                        class="ri-close-circle-line"></i> </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if (empty($from_date) && empty($to_date) && empty($search))
                <div class="d-flex justify-content-end">
                    {{ $inventaires->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
