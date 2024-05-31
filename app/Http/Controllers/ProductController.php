<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = (new Product())->getProductsQuery()->paginate(5);
        $companies = Company::getCompaniesQuery();
    
        if ($request->ajax()) {
            return view('partials.products', compact('products'))->render();
        }
    
        return view('index', compact('products', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('create')
        ->with('companies',$companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request) //store(Request $request)→ProductRequestに変える
    {
        DB::beginTransaction();

        try{
            $imagePath = null;
            if ($request->hasFile('img_path')) {
                $imagePath = $request->file('img_path')->store('images/products', 'public');
            }
            
            $product = new Product();
            $product->registProduct($request,$imagePath);
            DB::commit();

            return redirect(route('product.create'))
            ->with('success', '登録しました');
            
        } catch (\Exception $e){
            DB::rollback();
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {        
        $companies = Company::all();
        return view('edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
    
        try {
            $imagePath = null;
            if ($request->hasFile('img_path')) {
                $image = $request->file('img_path');
                $path = 'images/products';
                $imagePath = $image->store($path, 'public');
            }
    
            $product->update([
                'product_name' => $request->input('product_name'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'company_id' => $request->input('company_id'),
                'comment' => $request->input('comment'),
                'img_path' => $imagePath ?? $product->img_path,
            ]);
    
            DB::commit();
    
            return redirect(route('product.edit', $product->id))
            ->with('success', '変更しました');
    
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', '変更に失敗しました');
        }
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->deleteProduct();
    
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
    
        return redirect()->route('index')
            ->with('success', $product->product_name . 'を削除しました');
    }
    

    public function search(Request $request)
    {
        $query = (new Product())->getProductsQuery();
        
        // Add search filter if needed
        if ($request->filled('keyword')){
            $query->where('product_name', 'like', '%' . $request->input('keyword') . '%');
        }
    
        if ($request->filled('company_id')){
            $query->where('company_id', $request->input('company_id'));
        }
    
        if ($request->filled('price_min')){
            $query->where('price', '>=', $request->input('price_min'));
        }
    
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }
    
        if ($request->filled('stock_min')){
            $query->where('stock', '>=', $request->input('stock_min'));
        }
    
        if ($request->filled('stock_max')){
            $query->where('stock', '<=', $request->input('stock_max'));

        }

        if ($request->filled('sortColumn')) {
            $column = $request->input('sortColumn');
            $direction = $request->filled('sortDirection') ? $request->input('sortDirection') : 'asc';
            $query->orderBy($column, $direction);
        }
    
        $products = $query->paginate(5)->appends($request->except('page'));
    
        if ($request->ajax()) {
            return view('partials.products', compact('products'))->render();
        }
    
        return view('index', compact('products'));
    }    

}