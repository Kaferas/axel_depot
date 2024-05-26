@extends('layouts.template')
@section('header_title')
    Approvisionnements Listes
@endsection
@section('content')
    <div class="row mt-2 card p-1">
        <form action="{{ route('approvisionnements.index') }}" method="get" class="d-flex justify-content-between">
            @csrf
            <div class="row col-9 d-flex justify-content-center">
                <div class="mb-3 col-6">
                    <label for="example-date" class="form-label">Du:</label>
                    <input class="form-control d-inline-block" id="example-date" type="date" name="from_date"
                        value="{{ $from }}">
                </div>
                <div class="mb-3 col-3">
                    <label for="example-date" class="form-label">Au:</label>
                    <input class="d-inline-block form-control" id="example-date" type="date" name="to_date"
                        value="{{ $to }}">
                </div>
                <div class="mb-3 mt-1 col-3">
                    <label for="example-date" class="form-label"></label>
                    <select name="fournisseur" id="fournisseur" class="form-control">
                        <option value="" selected><span class="text text-info">Fournisseur par Default</span></option>
                        @foreach ($suppliers as $item)
                            <option value="{{ $item->id }}">{{ $item->nom_fournisseur }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3 col-3">
                <button type="submit" class="d-inline-block btn btn-xs btn-primary"><i class="ri-search-line"></i></button>
                {{-- <button type="reset" class="d-inline-block btn btn-xs btn-danger"><i class="ri-search-line"></i></button> --}}
                <a href="{{ route('approvisionnements.index') }}" type="reset"
                    class="d-inline-block btn btn-xs btn-secondary"><i class="ri-reply-line" title="Reinitialiser"></i></a>
                <a href="{{ route('approvisionnements.create') }}" class="d-inline-block btn btn-xs btn-info"><i
                        class="text text-light ri-add-box-line"></i></a>
            </div>
        </form>
        <div class="card p-3">
            <table id="tech-companies-1" class="table table-striped">
                <thead>
                    <tr>
                        <th data-priority="1">Title</th>
                        <th>Code </th>
                        <th data-priority="3" class="text-center">Fournisseur</th>
                        <th data-priority="1" class="text-center">Total</th>
                        <th data-priority="3" class="text-center">Date Creation</th>
                        <th data-priority="3" class="text-center">Crée par</th>
                        <th data-priority="3" class="text-center">Status</th>
                        <th data-priority="6" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approvisions as $item)
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
                            <td class="col-3"><b>{{ $item->approv_title }}</b></td>
                            <th><span class="co-name text-center">{{ $item->approv_code }}</span></th>
                            <td class="text-center">{{ $item->nom_fournisseur }}</td>
                            <td class="text-center">{{ $item->approv_amount }}</td>
                            <td class="text-center">{{ $item->created_at }}</td>
                            <td class="text-center">{{ $item->name }}</td>
                            <td class="text-center {{ $colorc }}">{{ $status }}</td>
                            <td class="text text-center">
                                <a href="{{ route('approvisionnements.show', $item->id) }}"
                                    title="Voir: {{ $item->approv_title }}" class="btn btn-sm btn-success"><i
                                        class="ri-eye-line"></i>
                                </a>

                                <button data-url="{{ route('approvisionnements.destroy', $item->id) }}"
                                    onclick="deleteArticle('{{ $item->id }}')"
                                    title="Supprimer: {{ $item->approv_title }}" class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#info-header-modal"><i
                                        class="ri-close-circle-line"></i> </button>
                            </td>
                        </tr>
                    @endforeach
                    @if (count($approvisions) <= 0)
                        <tr class="text text-center ">
                            <td colspan=7>Pas d'Approvisionnement Disponible</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if (empty($fournisseur) && empty($from) && empty($to))
                <div class="d-flex justify-content-end">
                    {{ $approvisions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
@section('js_content')
    <script>
        function deleteArticle(id) {
            alert(id)
        }
    </script>
@endsection
