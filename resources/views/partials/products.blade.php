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
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか？");'>削除</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{!! $products->links('pagination::bootstrap-5') !!}
