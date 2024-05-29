<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td style="text-align:right">{{ $product->id }}</td>
                <td><img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" width="45"></td>
                <td>{{ $product->product_name }}</td>
                <td style="text-align:right">{{ $product->price }}円</td>
                <td style="text-align:right">{{ $product->stock }}</td>
                <td>{{ $product->company_name }}</td>
                <td style="text-align:center">
                    <a class="btn btn-info" href="{{ route('product.show',$product->id) }}">詳細</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{!! $products->links('pagination::bootstrap-5') !!}
