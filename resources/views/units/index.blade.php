@extends('layouts.template')
@section('header_title')
    Listes des Unites de Mesures
@endsection
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">PAEEJ</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('units.index') }}">Unites</a></li>
                                <li class="breadcrumb-item active">Listes</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('units.index') }}" method="get">
                <div class="row m-2">
                    <div class="col-3">
                        <h4 class="page-title">Listes des Unites de Mesures
                        </h4>
                    </div>
                    <div class="col-6">
                        <input type="text" class="text form-control" placeholder="Rechercher Unite de Mesure"
                            name="searchUnit" value="{{ $unit }}">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-info">Chercher</button>
                        <a href="{{ route('units.create') }}" class="btn btn-warning" title="Ajouter Categorie"><i
                                class="text text-dark ri-add-box-line"></i></a>
                    </div>
                </div>
            </form>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="responsive-table-plugin">
                            <div class="table-rep-plugin">
                                <div class="table-responsive" data-pattern="priority-columns">
                                    <table id="tech-companies-1" class="table table-striped">
                                        @if (count($units) > 0)
                                            <thead>
                                                <tr>
                                                    <th>Nom Unite</th>
                                                    <th data-priority="1">Description</th>
                                                    <th data-priority="2" class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        @endif
                                        <tbody>
                                            @foreach ($units as $item)
                                                <tr>
                                                    <th><span class="co-name"><b>{{ $item->name_unit }}</b></span>
                                                    </th>
                                                    <td>{{ substr($item->description_unit, 0, 40) }}</td>
                                                    <td class="text text-center">
                                                        <a data-url="{{ route('units.update', $item->id) }}"
                                                            onclick="editUnit(this,'{{ $item->description_unit }}','{{ $item->name_unit }}')"
                                                            title="Modifier {{ substr($item->name_unit, 0, 40) }}"
                                                            class="btn btn-sm btn-success"><i class="ri-edit-2-line"></i>
                                                        </a>
                                                        <button onclick="deleteUnit({{ $item->id }})"
                                                            title="Supprimer {{ $item->name_unit }}"
                                                            class="btn btn-sm btn-danger"><i
                                                                class="ri-close-circle-line"></i> </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if (count($units) <= 0)
                                                <tr colspan="4" class="text-center">
                                                    <td>
                                                        Pas d'Unite Disponible
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div> <!-- end .table-responsive -->

                            </div> <!-- end .table-rep-plugin-->
                        </div> <!-- end .responsive-table-plugin-->
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

    </div> <!-- content -->
    <div id="info-header-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="info-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <h4 class="modal-title text text-center">Voulez-vous vraiment Supprimer</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h4>
                        <h2><i class="ri-error-warning-fill text-danger"></i></h2> L'action une fois faite il est
                        irréversible 🤔
                    </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                        id="modal-close-panel">Close</button>
                    <button type="button" class="btn btn-danger" id="modal-delete-confirm">Oui,Continuer</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="edit-modal-sm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modal-sm"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-info">
                    <h4 class="modal-title text text-center">Voulez-vous vraiment Modifier?</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="formModif">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="text text-info">Unite de Mesure:</label>
                            <input type="text" name="unit_edit" id="unit_edit"
                                class="form-control border border-primary">
                        </div>
                        <div class="form-group">
                            <label for="" class="text text-info">Description:</label>
                            <textarea name="description_edit" id="description_edit" cols="30" rows="4"
                                class="form-control border border-primary"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                            id="modal-close-panel">Close</button>
                        <button type="button" class="btn btn-info" id="edit-confirm">Oui,Continuer</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('js_content')
    <script>
        function deleteUnit(id) {
            $("#info-header-modal").modal("show");
            let close = $("#modal-close-panel")
            let confirm = $("#modal-delete-confirm")
            confirm.on("click", () => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'DELETE',
                    url: `{{ url('units/${id}/') }}`,
                    cache: false,
                    contentType: false,
                    success: (data) => {
                        if (data.ok = "success") {
                            $("#info-header-modal").modal("hide");
                            window.location.reload();
                        }
                    }
                })
            })
        }

        function editUnit(th, description, name) {
            $("#edit-modal-sm").modal("show")
            $("#unit_edit").val(name)
            $("#description_edit").val(description)
            let url = $(th).attr("data-url");
            $("#formModif").attr("action", url)
            let newUnit = $("#unit_edit").val();
            let newDescription = $("#description_edit").val();

            $("#edit-confirm").on("click", function() {
                let data = $("#formModif").serializeArray();
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}",
                        data: data
                    },
                    success: (data) => {
                        if (data.result) {
                            $("#edit-modal-sm").modal("hide");
                            window.location.reload();
                        }
                    }
                })
            })
        }
    </script>
@endsection
