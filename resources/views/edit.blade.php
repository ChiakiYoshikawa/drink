@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">

        <div class="pull-left">
            <h2 style="font-size:1.5rem;">商品編集画面</h2>
         </div>

    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

        <h3>ID:{{ $product->id }}</h3>

<div style="text-align:right;">
<form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
@method('PUT')
@csrf

<div class="row">

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <input type="text" name="product_name" class="form-control" placeholder="商品名" value="{{ $product->product_name }}">
            @if($errors->has('product_name'))
              <span style="color:red;">{{ $errors->first('product_name') }}</span>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <input type="text" name="price" class="form-control" placeholder="価格" value="{{ $product->price }}">
            @if($errors->has('price'))
              <span style="color:red;">{{ $errors->first('price') }}</span>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <input type="text" name="stock" class="form-control" placeholder="在庫数" value="{{ $product->stock }}">
            @if($errors->has('stock'))
              <span style="color:red;">{{ $errors->first('stock') }}</span>
            @endif
         </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <textarea name="comment" class="form-control" placeholder="コメント">{{ $product->comment }}</textarea>
            @if($errors->has('comment'))
                <span style="color:red;">{{ $errors->first('comment') }}</span>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <select name="company_id" class="form-select">
                <option value="">分類を選択してください</option>
                @foreach($companies as $company)
                  <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            @if($errors->has('company_id'))
              <span style="color:red;">{{ $errors->first('company_id') }}</span>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <input type="file" name="img_path" class="form-control-file">
            @if($errors->has('img_path'))
              <span style="color:red;">{{ $errors->first('img_path') }}</span>
            @endif
        </div>
    </div>

    <div class="d-flex">
        <div>
            <button type="submit" class="btn btn-warning w-100">変更</button>
        </div>

        <div>
            <a class="btn btn-info" href="{{ route('product.show', ['product' => $product->id]) }}">戻る</a>
        </div>
    </div>

    </div>

</form>
</div>
@endsection


