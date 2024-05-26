@extends('layouts.template')
@section('header_title')
    Ventes POS
@endsection
@section('content')
    <form id="approvForm" action="{{ route('sells.store') }}" method="post">
        @csrf
        <div class="container p-3">
            <div class="form-group">
                <label for="">Client:</label>
                <select name="client" id="client" class="form-control">
                    <option value="">Selectionner le Client</option>
                    @foreach ($clients as $item)
                        <option value="{{ $item->id }}">{{ $item->name_client }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row mt-3">
                <input type="text" name="searchArticle" id="searchArticle" class="border border-info p-2 form-control"
                    placeholder="Taper le Nom afin de Rechercher Article Ici" onkeyup="findProduct()">
                <ul id="articleAppend" hidden class="articleAppend bg-light text-dark list-unstyled col-12 container">
                    @foreach ($articles as $item)
                        <li class="singleItem" style="padding:7px" qty="{{ $item->quantite }}"
                            codebar="{{ $item->codebar_article }}" nameArt="{{ $item->article_name }}"
                            nameArt ="{{ $item->article_name }}" categorie="{{ $item->nom_categorie }}"
                            price="{{ $item->price_achat }}" class="p-2 mt-2 h4 text-bold border-bottom border-info pl-3">
                            <p><span class="text text-warning">{{ $item->article_name }}</span> | <span
                                    class="text text-info">{{ $item->codebar_article }} </span></p>
                        </li>
                    @endforeach
                </ul>
            </div>
            <table id="tech-companies-1" class="table table-striped">
                <thead>
                    <tr>
                        <th data-priority="1" class="text text-info"><b>Codebarre</b></th>
                        <th class="text text-info"><b>Nom Article</b></th>
                        <th data-priority="3" class="text-center text-info"><b>Quantite</b></th>
                        <th data-priority="3" class="text-center text-info"><b>Prix d'Achat</b></th>
                        <th data-priority="6" class="text-center text-info"><b>Total Prix</b></th>
                        <th data-priority="6" class="text-center text-info"><b>Action</b></th>
                    </tr>
                </thead>
                <tbody id="addArticle">
                </tbody>
            </table>
            <div class="d-flex justify-content-end ">
                <button hidden type="submit" class="mt-2 btn btn-md btn-info" id="btnSave_approv">Enregistrer
                    Commande </button>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="typePaiement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text text-center text-primary modal-title">Mode de Paiements</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Mode Paiement:</label>
                        <select name="modePaie" onchange="triggerMode()" id="modePaie" class="form-control">
                            <option value="1" selected>Cash</option>
                            <option value="2">Credit</option>
                            <option value="3">Cheque Bancaire</option>
                            <option value="4">Avance</option>
                        </select>
                    </div>
                    <div hidden id="avancee" class="mt-3 form-group">
                        <label for="" class="text text-info">Avance:</label>
                        <input type="text" name="avance" id="avanceeAmount" class="form-control"
                            placeholder="Entrer le Montant avance">
                    </div>
                </div>
                <div class="modal-footer">
                    <div data-commande="commande" class="confirmPaie btn btn-info">&nbsp;<i
                            class="ri-shopping-cart-2-fill"></i>
                        Commande</div>
                    <div data-commande="paie" class="confirmPaie btn btn-primary">&nbsp;<i
                            class="ri-money-dollar-box-line"></i>Payer</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_content')
    <script>
        var total_command = 0;
        const triggerMode = (e) => {
            let mode = $("#modePaie").val();
            if (mode == 4) {
                $("#avancee").removeAttr("hidden")
            } else {
                $("#avancee").attr("hidden", true)
            }
        }

        function findProduct() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("searchArticle");
            filter = input.value.toUpperCase();
            ul = document.getElementById("articleAppend");
            li = ul.getElementsByTagName("li");
            filter === '' ? $('#articleAppend').attr('hidden', 'true') : $('#articleAppend').removeAttr('hidden');
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("span")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
        var myarray = [];
        $(document).on('click', '.singleItem', function() {
            let codebar = $(this).attr('codebar');
            let qty = $(this).attr('qty');
            let nameArt = $(this).attr('nameArt');
            let categorie = $(this).attr('categorie');
            let price = $(this).attr('price');
            let uniteMesure = $(this).attr('uniteMesure');
            if (myarray.includes(codebar)) {
                Swal.fire({
                    type: 'success',
                    title: 'Desolé! Cet article existe deja dans le tableau ',
                    showConfirmButton: true,
                    // timer: 2500
                })
                $('#articleAppend').attr('hidden', 'true');
                $('#searchArticle').val('');
                return;
            } else {
                if (qty <= 0) {
                    Swal.fire({
                        type: 'success',
                        title: 'Desolé! la quantite de l\'article est moins de 1 ',
                        showConfirmButton: true,
                        // timer: 2500
                    });
                    return;
                } else {
                    myarray.push(codebar);
                    if (myarray.length > 0) {
                        $("#btnSave_approv").removeAttr("hidden")
                    }
                    $('#articleAppend').attr('hidden', 'true');
                    $('#searchArticle').val('');
                    let html = `<tr>
                    <td>${codebar}</td>
                    <td>${nameArt}</td>
                    <td><input  class='col-5 form-control' data-total='${price}' onkeyup="changeTotal(this,'${codebar}','${qty}')" type='text' name='qty[]' id='Qty${codebar}'></td>
                    <td><input readonly disabled class='col-5 form-control' data-total='${price}' type='number' value='${price}' onkeyup="changeTotal(this,'${codebar}','${qty}'s)" name='priceAchat[]'></td>
                    <td><input readonly  disabled class='col-5 form-control' type='number' id="totalAchat${codebar}" name='totalAchat[]'>
                        <input class='col-5 form-control' type='hidden' name='codebar[]' value='${codebar}'/>
                        <input class='col-5 form-control' type='hidden' name='price[]' value='${price}'/>
                        <input class='col-5 form-control' type='hidden' name='nameArt[]' value='${nameArt}'/>
                        </td>
                        <td><button class="btn btn-sm btn-danger del" data-code="${codebar}"><i class="ri-close-circle-line"></i></button></td>
                        </tr>`;
                    $("#addArticle").append(html)
                }
            }
        });

        $(document).on('click', '.del', function() {
            $(this).closest('tr').remove();
            codebar = $(this).attr("data-code")
            myarray = myarray.filter((data) => {
                return data != codebar;
            });
            if (myarray.length <= 0) {
                $("#btnSave_approv").attr('hidden', 'true')
            }
        })

        $("#avanceeAmount").on("keyup", (e) => {
            let tapped = e.target.value;
            let grabbed = $("#avanceeAmount").val()
            if (grabbed >= total_command) {
                $("#avanceeAmount").val(0)
                $("#avancee").attr("hidden", true)
                $("#modePaie").val(1)
            }
            if (tapped > total_command) {
                $("#avanceeAmount").val(total_command)
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `Montant Avance peux pas depasser: ${total_command}`,
                });
            }
        })

        // function triggerNotSurpass(e) {
        //     console.log(e.target.value)
        //     // console.log(total_command)
        // }


        function changeTotal(e, code, qty) {
            $(`#totalAchat${code}`).val(0);
            let total = parseInt($(e).attr('data-total'));
            let v = parseInt(e.value);
            if (isNaN(v)) {
                e.value = 0
                v = 0
            }
            if (v > qty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `La quantite saisie est superieur a ${qty}`,
                })
                $(`#Qty${code}`).val(qty)
                v = qty;
            }
            $(`#totalAchat${code}`).val(parseInt(total * v))
        }

        $("#btnSave_approv").on("click", (e) => {
            e.preventDefault();
            let form = $("#approvForm").serializeArray()
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = $("#approvForm").attr('action');
            let client = $("#client").val();
            if (client == '') {
                Swal.fire("Veuillez definir le Client");
                return;
            }

            let quantity = form.filter((ele) => ele.name == "qty[]").map(x => x.value)
            let prices = form.filter((ele) => ele.name == "price[]").map(x => x.value)
            quantity.forEach((element, idx) => {
                total_command += parseFloat(element) * parseFloat(prices[idx]);
            });
            $("#typePaiement").modal("show", true);
            $(this).attr("disabled", true);
            $(".confirmPaie").on("click", (e) => {
                let casePaid = e.target.getAttribute("data-commande");
                let avance = $("#avanceeAmount").val();
                $(this).prop("disabled", true);
                let mode = $("#modePaie").val();
                avance.length ? avance : 0;
                form.push({
                    "name": "mode",
                    "value": mode
                }, {
                    "name": "avance",
                    "value": avance
                }, {
                    "name": "casePaid",
                    "value": casePaid
                })

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form,
                    success: function(data) {
                        if (data.result) {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'success',
                                title: 'Vente effectue avec Success',
                                showConfirmButton: false,
                                timer: 1800
                            })
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('invoices.index') }}";
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
        })
    </script>
@endsection
