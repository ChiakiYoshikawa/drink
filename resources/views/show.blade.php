@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">

        <div class="pull-left">
            <h2 style="font-size:1.5rem;">商品情報詳細画面</h2>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-12 mb-2 mt-2">
        <p>ID:{{ $product->id }}</p>
        <p>商品画像:
        <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" width="100">
        </p>
        <p>商品名:{{ $product->product_name }}</p>
        <p>価格:{{ $product->price }}円</p>
        <p>在庫数:{{ $product->stock }}</p>
        <p>メーカー名:{{ $product->company->company_name }}</p>
        <p>コメント:{{ $product->comment }}</p>
    </div>
</div>

<div class="d-flex"> <!--d-flex　水平に並べるという意味-->
   <div>
    <a class="btn btn-warning" href="{{ route('product.edit', ['product' => $product->id]) }}">編集</a>
   </div> 
   
<div class="pull-right">
    <a class="btn btn-info" href="{{ url('/drink') }}">戻る</a>
</div>

@endsection