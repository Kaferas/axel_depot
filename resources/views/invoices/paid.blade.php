@extends('layouts.template')
@section('header_title')
    Paiements Commande : {{ $invoice }}
@endsection
@section('content')
    <div class="row mt-4 col-12 d-flex justify-content-end">
        @if ($reste >= 0)
            <button data-commande="{{ $invoice }}" id="addPaie" class="col-2 btn btn-primary"><i
                    class="ri ri-add-line"></i>
                Ajouter Paiement</button>
        @endif
        &nbsp;
        <div title="Imprimer PDF" class="col-sm-1 btn btn-info text-light"><i class="ri-file-pdf-line"></i> PDF</div>
    </div>
    @if (count($paiements) > 0 and $way == 'paiements')
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Montant a Payer</th>
                    <th>Avance</th>
                    <th>Mode Paiement</th>
                    <th>Date Paiement</th>
                    <th>Cree Par</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paiements as $i => $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $item->clients->name_clients . ' ' . $item->clients->prenom_client }}</td>
                        <td>{{ $item->montant_paiement }}</td>
                        <td>{{ $item->avance }}</td>
                        <td>{{ App\Helpers\getMode($item->mode_paiement) }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                        <td>{{ $item->user->name . ' ' . $item->user->fullName }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="card text text-center text-warning p-3 mt-4">
            <h4>Aucune Paiement sur cette Commande Disponible</h4>
        </div>
    @endif

    <div class="modal fade" id="typePaiement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text text-center text-primary modal-title">Paiements Commande <span
                            class="text text-secondary" id="codeCommande"></span>
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="form-group p-2">
                        <label for="">Montant Payer</label>
                        <input data-max="{{ $reste }}" type="text" name="paidAmount" id="paidAmount"
                            class="text form-control">
                    </div>
                    <div class="form-group p-2">
                        <label for="">Mode Paiement:</label>
                        <select name="modePaie" id="modePaie" class="form-control">
                            <option value="1" selected>Cash</option>
                            <option value="4">Avance</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="confirmPaie" data-commande="paie" class="confirmPaie btn btn-primary">&nbsp;
                        <i class="ri-money-dollar-box-line"></i>Payer
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_content')
    <script>
        $("#addPaie").on("click", function() {
            $("#typePaiement").modal("show")
            let codeCommande = $(this).attr("data-commande");
            $("#codeCommande").html(codeCommande)
            $("#confirmPaie").attr("data-commande", codeCommande)
        })

        $("#paidAmount").on("keyup", function(e) {
            let max = parseInt($(this).attr("data-max"));
            let typed = parseInt(e.target.value);
            if (typed > max) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `Montant Avance peux pas depasser: ${max}`,
                });
                $("#paidAmount").val(max)
            }
        })

        $("#confirmPaie").on("click", () => {
            let url = "{{ url('paidReste') }}"
            let amount = $("#paidAmount").val();
            let mode = $("#modePaie").val();
            let reste = "{{ $reste }}";
            let commande = "{{ $invoice }}"
            let client = "{{ $paiements[0]->client_id }}"
            let data_post = {
                "amount": amount,
                "mode": mode,
                "reste": reste,
                "commande": commande,
                "client": client
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    data_post
                },
                success: function(data) {
                    if (data.result) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: 'Facture Cree avec Success',
                            showConfirmButton: false,
                            timer: 1800
                        })
                        setTimeout(() => {
                            window.location.href = "{{ route('invoices.index') }}";
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Erreur lors de l\'enregistrement',
                        })
                    }
                },
                error: function(xhr, b, c) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Quelque chose s\'est mal Tourne',
                    })
                }
            });
        })
    </script>
@endsection
