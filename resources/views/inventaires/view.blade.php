@extends('layouts.template')
@section('header_title')
    Inventaire View
@endsection

@section('content')
    <div class="card p-3 mt-2">
        <div class="row">
            <div class="col-5">
                <h4>Details Inventaire: <span class="text text-info">{{ $inventaire->inventory_code }} </span>
                    &nbsp;&nbsp;&nbsp; Du:&nbsp; <span class="text text-info">
                        {{ $inventaire->created_at }}</span>
                </h4>
            </div>
            <div class="col-5">
                <h4>Crée par: <span class="text text-info">{{ strtoupper($details[0]->name) }}</span></h4>
            </div>
            <div class="col-2">
                <button class="btn btn-primary"
                    onclick="ExportToExcel('tech-companies-1','Inventaire du Mois de {{ date('m') }}')"><i
                        class="ri-file-excel-2-line"></i></button>
            </div>
        </div>
    </div>
    <div class="card">
        <table id="tech-companies-1" class="table table-striped">
            <thead>
                <?php
                $attente = 0;
                $approve = 0;
                $reject = 0;
                $total = 0;
                ?>
                <tr>
                    <th data-priority="1">Code Bar</th>
                    <th>Intitule</th>
                    <th data-priority="3" class="text-center">Quantite Theorique</th>
                    <th data-priority="3" class="text-center">Quantite Physique</th>
                    <th data-priority="1" class="text-center">Prix d'Achat</th>
                    <th data-priority="3" class="text-center">Total</th>
                    <th data-priority="3" class="text-center">Status</th>
                    @if (count($details) == $attente || $attente >= 1)
                        <th data-priority="6" class="text-center">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>

                @foreach ($details as $item)
                    @if ($item->status_inventaire == 0)
                        <?php $status = 'En Attente';
                        $color = 'text text-warning';
                        $attente += 1;
                        ?>
                    @elseif($item->status_inventaire == 1)
                        <?php $status = 'Approuve';
                        $color = 'text text-info';
                        $approve += 1;
                        ?>
                    @else
                        <?php $status = 'Rejette';
                        $color = 'text text-danger';
                        $reject += 1;
                        ?>
                    @endif
                    <tr>
                        <td><b>{{ $item->codebar_article }}</b></td>
                        <th><span>{{ $item->name_article_inventaire }}</span></th>
                        <td class="text-center">{{ $item->qty_theorique_inventaire }}</td>
                        <td class="text-center">{{ $item->qty_physique_inventaire }}</td>
                        <td class="text-center">{{ $item->price_article }}</td>
                        <td class="text-center">{{ $item->price_article * $item->qty_physique_inventaire }}</td>
                        <td class="text-center <?= $color ?>">{{ $status }}</td>
                        @if ($item->status_inventaire == 0)
                            <td class="text text-center">
                                <button data-url="{{ route('inventaires_details.update', $item->id) }}"
                                    title="Editer {{ $item->name_article_inventaire }}"
                                    onclick="modifArticle('{{ $item->name_article_inventaire }}','{{ $item->qty_physique_inventaire }}','{{ $item->price_article }}','{{ $item->id }}','{{ $item->qty_theorique_inventaire }}')"
                                    id="modif{{ $item->id }}" class="btn btn-sm btn-success"><i class="ri-edit-2-line"
                                        data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm"></i>
                                </button>
                                <button data-url="{{ route('inventaires_details.destroy', $item->id) }}" id="eraseBtn"
                                    onclick="supprimerArticle('{{ $item->name_article_inventaire }}','{{ $item->id }}')"
                                    title="Supprimer {{ $item->name_article_inventaire }}" class="btn btn-sm btn-danger"><i
                                        class="ri-close-circle-line" data-bs-toggle="modal"
                                        data-bs-target="#delete-example-modal-sm"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                    <?php $total += $item->price_article * $item->qty_physique_inventaire; ?>
                @endforeach
                <div>
                    <tr>
                        <td><i>TOTAL GEN</i></td>
                        <td colspan=5><b>{{ $total }}</b></td>
                    </tr>
                </div>
                @can('is_gerant')
                    @if (count($details) == $attente || $attente >= 1)
                        <div>
                            <tr class="d-flex p-2 justify-content-end">
                                <td>
                                    <button class="btn btn-md btn-success"
                                        data-url="{{ route('confirmer_inventaire', $inventaire->inventory_code) }}"
                                        id="approv-modal-confirm"
                                        onclick="approveModal('{{ $inventaire->inventory_code }}')">Valider
                                        Inventaire
                                    </button>

                                </td>
                            </tr>
                        </div>
                    @endif
                @endcan
            </tbody>
        </table>

    </div>

    <div class="modal fade" id="bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="mySmallModalLabel">Modifier: <span id="modNameArt"
                            class="text text-info"></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="modifArt">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Quantite</label>
                            <input type="number" name="modQty" id="modQty" class="form-control">
                            <input type="hidden" name="modQtyTh" id="modQtyTh" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Price</label>
                            <input type="number" name="modPrice" id="modPrice" class="form-control">
                            <input type="hidden" name="idDetail" id="idDetail" class="form-control">
                        </div>
                        <div class="form-group mt-1 d-flex justify-content-end">
                            <button type="submit" class="btn btn-md btn-warning" id="approveModif">Modifier</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="delete-example-modal-sm" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="mySmallModalLabel">Supprimer: <span id="supNameArt"
                            class="text text-info"></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="supprArt">
                        @csrf
                        <div class="form-group">
                            <label for="">Raison de Suppression</label>
                            <textarea class="form form-control" name="reasonDel" id="reasonDel" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group mt-1 d-flex justify-content-end align-items-between">
                            <button class="btn btn-md btn-secondary" id="supSingle">Annuler</button>
                            <button class="btn btn-md btn-danger" id="supNext">Continuer</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="approve-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="mySmallModalLabel">Valider l'inventaire: <span id="apprEntry"
                            class="text text-info"></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body text-center">
                        <h3>
                            <h5 class="text text-primary">Une fois Validé l'Inventaire Affectera le Stock 😊</h5>
                        </h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                            id="modal-close-panel">Close</button>
                        <button type="button" class="btn btn-danger" id="confirm-modal-sm">Oui,Continuer</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('js_content')
    <script>
        function modifArticle(name, qty, price, id, qth) {
            let btn = $(`#modif${id}`);
            let url = btn.attr('data-url');
            $("#modNameArt").html(name)
            $("#modQty").val(qty)
            $("#modQtyTh").val(qth)
            $("#modPrice").val(price)
            $("#idDetail").val(id)
            $("#modifArt").attr("action", url)
            $("#modifArt").on("submit", function(e) {
                e.preventDefault();
                let all = $("#modifArt").serializeArray();
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: all,
                    success: function(data) {
                        if (data.result) {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'success',
                                title: 'Modification Effectue Cree avec Success',
                                showConfirmButton: false,
                                timer: 1800
                            })
                            setTimeout(() => {
                                window.location.href = "{{ url()->full() }}";
                            }, 2000);
                        } else {
                            alert("Erreur lors de l'enregistrement")
                        }
                    },
                    error: function(xhr, b, c) {
                        alert("Quelque chose s'est mal Tourne")
                    }
                });
            })
        }

        function supprimerArticle(name, id) {
            $("#supNameArt").html(name)
            $("#supSingle").on("click", function(e) {
                e.preventDefault()
                $("#delete-example-modal-sm").modal('hide')
            })
            $("#supNext").on("click", function(e) {
                e.preventDefault()
                let url = $("#eraseBtn").attr("data-url")
                let reason = $("#reasonDel").val()
                if (reason != '') {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            reason
                        },
                        success: function(data) {
                            if (data.success) {
                                window.location.href = "{{ url()->full() }}";
                            } else {
                                alert("Erreur lors de l'enregistrement")
                            }
                        },
                        error: function(xhr, b, c) {
                            alert("Quelque chose s'est mal Tourne")
                        }
                    });
                } else {
                    alert("Raison de Suppression Obligatoire")
                }

            })
        }



        function ExportToExcel(id, name, dl) {
            var elt = document.getElementById(id);
            var type = 'xlsx';
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            return XLSX.writeFile(wb, name + '.xlsx');
            // return dl ?
            //     XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
            //     XLSX.writeFile(wb, name || ('MySheetName.' + (type || 'xlsx')));

        };

        function approveModal(codebar) {
            $("#apprEntry").html(codebar)
            $("#approve-modal-sm").modal("show")
            let url = $("#approv-modal-confirm").attr("data-url");

            $("#confirm-modal-sm").on("click", () => {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data.result) {
                            window.location.href = "{{ route('inventaires.index') }}";
                        } else {
                            alert("Erreur lors de l'enregistrement")
                        }
                    },
                    error: function(xhr, b, c) {
                        alert("Quelque chose s'est mal Tourne")
                    }
                });

            })

        }
    </script>
@endsection
