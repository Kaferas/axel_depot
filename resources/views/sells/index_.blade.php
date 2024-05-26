@extends('layouts.template')
@section('header_title')
    Ventes POS
@endsection
@section('content')
    <style>
        body {
            /* background-color: cornsilk */
        }

        .cart {
            width: 14%;
            min-width: 150px;
            height: 120px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: space-between;
            border-radius: 15px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px;
            background-color: whitesmoke;
            cursor: pointer;
            user-select: none;
            border: 1px solid rgb(72, 70, 70);
        }

        .cart:active {
            width: 14%;
            min-width: 150px;
            height: 120px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            cursor: pointer;
            user-select: none;
            align-items: space-between;
            border-radius: 15px;
            box-shadow: rgba(240, 46, 170, 0.4) 5px 5px, rgba(240, 46, 170, 0.3) 10px 10px, rgba(240, 46, 170, 0.2) 15px 15px, rgba(240, 46, 170, 0.1) 20px 20px, rgba(240, 46, 170, 0.05) 25px 25px;
            background-color: whitesmoke;
            border: 1px solid rgb(72, 70, 70);
        }

        .rtop {
            margin-top: 0px;
            display: flex;
            justify-content: flex-start;
        }

        .pos-height {
            height: 70vh;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-color: blue;
            scrollbar-width: thin;
        }
    </style>
    <div class="row">
        <div class="col-6">
            <div class="text text-center card m-2 p-2">
                <h4>POS</h4>
            </div>
            <div class="container my-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="search"
                        placeholder="Chercher Icii par le Nom ou Codebarre">
                </div>
            </div>
            <div class="pos-height">
                <div class="d-flex justify-content-around rtop row">
                    @foreach ($articles as $item)
                        <div class="cart"
                            onclick="handleCart('{{ $item->codebar_article }}', '{{ json_encode($item) }}')">
                            <h5 class="text text-info"><i>{{ $item->article_name }}</i></h5>
                            <div class="text text-warning">Price: {{ $item->price_vente }} FBU</div>
                            <div class="text text-secondary">Q: {{ $item->quantite }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card m-2 p-2 text text-center">
                <h4>CART VENTE</h4>
            </div>
        </div>
    </div>
@endsection

@section('js_content')
    <script>
        var cart = [];
        const handleCart = (code, item) => {
            let obj = JSON.parse(item);
            let c = {
                "codebar": code,
                "name": obj.article_name,
                "price": obj.price_vente,
                "qty": 1
            }
            cart.push(c)
            Object.assign({}, cart)
        }
    </script>
@endsection
