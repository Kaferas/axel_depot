@extends('layouts.template')
@section('header_title')
    Details Factures
@endsection
@section('content')
    <div class="p-4 row">
        <div class="col-6">
            <p>Facture Numero: <b><?= $invoice[0]->invoice_number ?></b></p>
            <p>Centre fiscal d'activité :DMC</p>
            <p>Forme juridique :sprl</p>
            <p>Commune :Mutimbuzi</p>
        </div>
        <div class="col-6">
            <p>NIF: </p>
            <p>Secteur d'activité :Commerce</p>
            <p>Tél :76197000</p>
            <p>Quartier :Kajaga , Rumonge</p>
            <p>Assujeti à la TVA : OUI</p>
        </div>
        <div>
            <p><b>CLIENTS</b></p>
            <p>
                NOM :CLIENT CASH
            </p>
            <p>Assujeti à la TVA : Oui | Non</p>
        </div>
        <table class="table table-striped col-12">
            <thead>
                <tr>
                    <th>Articles</th>
                    <th>Quantites</th>
                    <th>PU</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($invoice as $item)
                    <tr>
                        <td>{{ $item->name_produit }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price_product }}</td>
                        <td>{{ $item->price_product * $item->quantity }}</td>
                    </tr>
                    <?php
                    $total += $item->price_product * $item->quantity;
                    ?>
                @endforeach
            </tbody>
            <br>
            <div class="mt-4 d-flex justify-content-end">
                <div>
                    <tr>
                        <td>TOTAL HTVA</td>
                        <td><?= $total ?></td>
                    </tr>
                    <tr>
                        <td>TVA</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>TOTAL NET</td>
                        <td><?= $total ?></td>
                    </tr>
                </div>
            </div>
        </table>
    </div>
@endsection
@section('js_content')
    <script>
        window.print()
    </script>
@endsection
