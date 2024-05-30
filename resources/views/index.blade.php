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
                <input type="submit" value="検索">
            </form>
        </div>
        <div class="text-right">
            <a class="btn btn-warning" href="{{ route('product.create') }}">新規登録</a>
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
    // 検索フォームの送信
    $(document).on('submit', '#searchForm', function(e) {
        e.preventDefault();
        fetchProducts($(this).attr('action'), $(this).serialize());
    });

    // ページネーションリンクのクリック
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        fetchProducts($(this).attr('href'));
    });

    // 商品を取得する関数
    function fetchProducts(url, data = {}) {
        $.ajax({
            url: url,
            data: data,
            success: function(response) {
                $('#productTable').html(response);
                addSortingHandlers(); // ソート機能のハンドラを再度追加
                addDeleteHandlers(); // 削除機能のハンドラを再度追加
            },
            error: function(xhr) {
                console.error(xhr);
                alert('データの取得に失敗しました。');
            }
        });
    }

    // 商品を削除する関数
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

    // ソート機能のハンドラを追加する関数
    function addSortingHandlers() {
        $('#productTable th.sortable').click(function() {
            var table = $(this).parents('table').eq(0);
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
            this.asc = !this.asc;
            if (!this.asc) {
                rows = rows.reverse();
            }
            for (var i = 0; i < rows.length; i++) {
                table.append(rows[i]);
            }
        });
    }

    function comparer(index) {
        return function(a, b) {
            var valA = getCellValue(a, index);
            var valB = getCellValue(b, index);
            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
        };
    }

    function getCellValue(row, index) {
        return $(row).children('td').eq(index).text();
    }

    // 削除機能のハンドラを追加する関数
    function addDeleteHandlers() {
        $(document).on('click', '.delete-product', function(e) {
            e.preventDefault();
            if (confirm('本当に削除しますか？')) {
                var productId = $(this).data('product-id');
                deleteProduct(productId);
            }
        });
    }

    // 初期化処理
    $(document).ready(function() {
        addSortingHandlers(); // ソート機能のハンドラを初期化
        addDeleteHandlers(); // 削除機能のハンドラを初期化
    });
</script>
@endsection
