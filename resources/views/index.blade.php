@extends('app')

@section('content')
<div class="row">
  <div class="col-lg-12"> <!--col-lg-12はBootstrapフレームワーク　1行全体の幅を占める列を定義　その中のコンテンツは行全体の幅に表示される-->

    <div class="text-left">
      <h2 style="font-size:1.5rem;">商品一覧画面</h2>
    </div>

    <div class="text-right"> <!--あとでいじるかも　text-end-->
      <a class="btn btn-success" href="#">新規登録</a>
    </div>

  </div>
</div>

<table class="table table-bordered">

  <thead>
    <tr>
      <th>No</th>
      <th>商品画像</th>
      <th>商品名</th>
      <th>価格</th>
      <th>在庫数</th>
      <th>メーカー名</th>
    </tr>
  </thead>

  @foreach($products as $product)
  <tbody>
    <tr>
      <td style="text-align:right">{{ $product->id }}</td>
      <td>
      <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" width="45">
      </td>
      <td>{{ $product->product_name }}</td>
      <td style="text-align:right">{{ $product->price }}円</td>
      <td style="text-align:right">{{ $product->stock }}</td>
      <td>{{ $product->company_name }}</td>
    </tr>
  </tbody>
  @endforeach

</table>

{!! $products->links('pagination::bootstrap-5') !!}
@endsection
