<table class="table table-bordered">
    <thead>
        <tr>
            <th class="sortable" data-field="id" data-order="asc">No</th>
            <th>商品画像</th>
            <th class="sortable" data-field="product_name" data-order="asc">商品名</th>
            <th class="sortable" data-field="price" data-order="asc">価格</th>
            <th class="sortable" data-field="stock" data-order="asc">在庫数</th>
            <th class="sortable" data-field="company_name" data-order="asc">メーカー名</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr id="product-{{ $product->id }}">
                <td style="text-align:right">{{ $product->id }}</td>
                <td><img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" width="45"></td>
                <td>{{ $product->product_name }}</td>
                <td style="text-align:right">{{ $product->price }}円</td>
                <td style="text-align:right">{{ $product->stock }}</td>
                <td>{{ $product->company_name }}</td>
                <td style="text-align:center">
                    <a class="btn btn-info" href="{{ route('product.show', $product->id) }}">詳細</a>
                    <form id="deleteForm_{{ $product->id }}" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger delete-product" data-product-id="{{ $product->id }}">削除</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{!! $products->links('pagination::bootstrap-5') !!}
