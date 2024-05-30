@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="text-left">
            <h2 style="font-size:1.5rem;">商品一覧画面</h2>
        </div>
        <div>
            <form id="searchForm" action="{{ route('product.search') }}" method="GET">
                @csrf
                <input type="text" name="keyword" placeholder="商品名">
                <select name="company_id">
                    <option value="">分類を選択してください</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
                <div>
                    <input type="number" name="price_min" placeholder="最低価格" min="0">
                    <input type="number" name="price_max" placeholder="最高価格" min="0">
                </div>
                <div>
                    <input type="number" name="stock_min" placeholder="最低在庫数" min="0">
                    <input type="number" name="stock_max" placeholder="最高在庫数" min="0">
                </div>
                <select id="sortColumn" name="sortColumn">
                    <option value="">並び替え</option>
                    <option value="id">No</option>
                    <option value="product_name">商品名</option>
                    <option value="price">価格</option>
                    <option value="stock">在庫数</option>
                    <option value="company_name">メーカー名</option>
                </select>
                <input type="submit" value="検索">
            </form>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div id="productTable">
    @include('partials.products', ['products' => $products])
</div>

@endsection

@section('scripts')
<script>
    $(document).on('submit', '#searchForm', function(e) {
        e.preventDefault();
        fetchProducts($(this).attr('action'), $(this).serialize());
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        fetchProducts($(this).attr('href'));
    });

    function fetchProducts(url, data = {}) {
        $.ajax({
            url: url,
            data: data,
            success: function(response) {
                $('#productTable').html(response);
            },
            error: function(xhr) {
                console.error(xhr);
                alert('データの取得に失敗しました。');
            }
        });
    }

    function deleteProduct(productId) {
        if (confirm("本当に削除しますか？")) {
            $.ajax({
                url: '/product/' + productId,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.success) {
                        alert('削除しました');
                        $('#product-' + productId).remove();
                    } else {
                        alert('削除に失敗しました');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                }
            });
        }
    }



    $(document).ready(function() {
        $('#sortColumn').change(function() {
            var column = $(this).val();
            var url = "{{ route('product.search') }}";
            var data = $('#searchForm').serialize() + '&sortColumn=' + column;
            
            $.ajax({
                url: url,
                data: data,
                type: 'GET',
                success: function(response) {
                    $('#productTable').html(response);
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('データの取得に失敗しました。');
                }
            });
        });
    });

</script>

@endsection