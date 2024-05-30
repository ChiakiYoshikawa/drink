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
    $('#productTable th').click(function() {
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
});

</script>

@endsection