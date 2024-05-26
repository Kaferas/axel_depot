@extends('layouts.template')
@section('header_title')
    Nouveau Inventaire
@endsection
@section('content')
    <style>
        .singleItem:hover {
            background-color: rgba(32, 62, 64, 0.879);
            color: white;
            width: 100%;
        }
    </style>
    <div class="row card d-flex p-3 mt-2">
        <form id="approvForm" action="{{ route('inventaires.store') }}" method="post">
            @csrf
            <div class="row col-12">
                <div class="mb-3 col-6">
                    <label for="example-date" class="form-label text text-info">Title:</label>
                    <input type="text" name="title_approv" id="" class="form-control"
                        placeholder="Inventaire du {{ date('d/m/Y') }}" value="Inventaire du {{ date('d/m/Y') }}">
                </div>
                <div class="mb-3 col-6">
                    <label for="example-date" class="text text-info form-label">Description:</label>
                    <input type="text" name="description" id="description" class="form-control">
                </div>
            </div>
            <div class="row mt-3">
                <input type="text" name="searchArticle" id="searchArticle" class="border border-info p-2 form-control"
                    placeholder="Taper le Nom afin de Rechercher Article Ici" onkeyup="findProduct()">
                <ul id="articleAppend" hidden class="articleAppend bg-light text-dark list-unstyled col-12 container">
                    @foreach ($articles as $item)
                        <li class="singleItem" style="padding:7px" qty="{{ $item->quantite }}"
                            codebar="{{ $item->codebar_article }}" nameArt="{{ $item->article_name }}"
                            categorie="{{ $item->nom_categorie }}" price="{{ $item->price_achat }}"
                            class="p-2 mt-2 h4 text-bold border-bottom border-info pl-3">
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
                        <th data-priority="3" class="text-center text-info"><b>Quantite Theorique</b></th>
                        <th data-priority="3" class="text-center text-info"><b>Quantite Physique</b></th>
                        <th data-priority="6" class="text-center text-info"><b>Difference</b></th>
                        <th data-priority="6" class="text-center text-info"><b>Action</b></th>
                    </tr>
                </thead>
                <tbody id="addArticle">
                </tbody>
            </table>
            <div class="d-flex justify-content-start">
                <button type="submit" class="mt-2 btn btn-md btn-info" id="btnSave_inventory">Terminer
                    Inventaire </button>
            </div>
        </form>

    </div>
@endsection
@section('js_content')
    <script>
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
                console.log(txtValue)
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
                });
                $('#articleAppend').attr('hidden', 'true');
                $('#searchArticle').val('');
                return;
            } else {
                myarray.push(codebar);
                $('#articleAppend').attr('hidden', 'true');
                $('#searchArticle').val('');
                let html = `<tr>
                    <td>${codebar}</td>
                    <td>${nameArt}</td>
                    <td><input disabled  readonly class='col-5 form-control' data-total='${price}' type='number' name='qtyTh[]' id='Qty' value='${qty}'></td>
                    <td><input class='col-5 form-control text-center' data-total='${qty}' type='number'  onkeyup="changeTotal(this,'${codebar}')" name='qtyPh[]'></td>
                    <td><input readonly  disabled class='col-5 form-control text-center' type='number' id="totalAchat${codebar}" name='totalAchat[]'>
                    <input class='col-5 form-control' type='hidden' name='codebar[]' value='${codebar}'/>
                    <input class='col-5 form-control' type='hidden' name='price[]' value='${price}'/>
                    <input class='col-5 form-control' type='hidden' name='qtyTh[]' value='${qty}'/>
                    <input class='col-5 form-control' type='hidden' name='nameArt[]' value='${nameArt}'/>
                    </td>
                    <td><button class="btn btn-sm btn-danger del" data-code="${codebar}"><i class="ri-close-circle-line"></i></button></td>
                </tr>`;
                $("#addArticle").append(html)
            }
        });

        $(document).on('click', '.del', function() {
            $(this).closest('tr').remove();
            codebar = $(this).attr("data-code")
            myarray = myarray.filter((data) => {
                return data != codebar;
            });
            console.log(myarray);
        })

        function changeTotal(e, code) {
            $(`#totalAchat${code}`).val(0);
            let qty = parseInt($(e).attr('data-total'));
            let v = parseInt(e.value);
            if (isNaN(v)) {
                e.value = 0
                v = 0
            }
            $(`#totalAchat${code}`).val(parseInt(qty - v))
        }

        $("#btnSave_inventory").on("click", (e) => {
            e.preventDefault();
            let form = $("#approvForm").serialize()
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = $("#approvForm").attr('action');
            let title = $("#title_approv").val();
            let description = $("#description").val();
            let QtyPh = $("#qtyPh").val();
            let QtyTh = $("#qtyTh").val();
            $("#btnSave_inventory").attr("disabled", true)
            if (title == '' || description == "" || QtyPh == '' || QtyTh == '') {
                Swal.fire("Veuillez Completer tous les Champs");
                return;
            }
            $(this).attr("disabled", true);
            $.ajax({
                url: url,
                type: 'POST',
                data: form,
                success: function(data) {
                    if (data.result) {
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: 'Approvisionnement Cree avec Success',
                            showConfirmButton: false,
                            timer: 1800
                        })
                        setTimeout(() => {
                            window.location.href = "{{ route('inventaires.index') }}";
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
