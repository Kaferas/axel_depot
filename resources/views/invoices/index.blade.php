@extends('layouts.template')
@section('header_title')
    Listes des Factures
@endsection
@section('content')
    <div class="p-3">
        <h3>Listes des Factures</h3>
        <div class="card p-3">
            <div class="d-flex justify-content-around">
                <div class="form-group col-2">
                    <label for="" class="text text-info">Numero Facture</label>
                    <input type="text" name="" id="" placeholder="F-00005" class="form-control border-dark">
                </div>
                <div class="form-group col-2">
                    <label for="" class="text text-info">Du:</label>
                    <input type="date" name="" id="" class="form-control border-dark">
                </div>
                <div class="form-group col-2">
                    <label for="" class="text text-info">Au:</label>
                    <input type="date" name="" id="" class="form-control border-dark">
                </div>
                <div class="form-group col-2">
                    <label for="" class="text text-info">Status </label>
                    <select name="" id="" class="form-control border-dark">
                        <option value="">Cash</option>
                        <option value="">Credit </option>
                        <option value="">Avance </option>
                        <option value="">Cheque Bancaire </option>
                    </select>
                </div>
                <div class="mt-3 col-2 form-group">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
        <table class="text-center table table-striped">
            <thead>
                <tr>
                    <th>ID</td>
                    <th>Facture N</th>
                    <th>Commande N</th>
                    <th>Montant</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th>Date Emission</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $i => $item)
                    <?php
                    $status = '';
                    $color = '';
                    if ($item->type_paie == 1) {
                        $color = 'text text-primary';
                        $status = 'Cash';
                    } elseif ($item->type_paie == 2) {
                        $color = 'text text-danger';
                        $status = 'Credit';
                    } elseif ($item->type_paie == 3) {
                        $color = 'text text-info';
                        $status = 'Cheque Bancaire';
                    } else {
                        $color = 'text text-warning';
                        $status = 'Avance';
                    }
                    ?>
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $item->invoice_number }}</td>
                        <td>{{ $item->commande_code }}</td>
                        <td>{{ $item->amount_commande }}</td>
                        <td>{{ $item->name_client . ' ' . $item->prenom_client }}</td>
                        <td class="{{ $color }}">{{ $status }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $item->id) }}" class="btn btn-sm btn-info"><i
                                    class="ri-eye-line"></i></a>
                            @if ($item->type_paie == 2 || $item->avance_amount != 0 || empty($item->invoice_number))
                                <a class="btn btn-dark btn-sm text-light"
                                    href="{{ route('paid', $item->commande_code) }}"><i
                                        class="ri-money-dollar-box-line"></i></a>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
