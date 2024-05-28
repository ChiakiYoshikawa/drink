<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ //セキュリティのためにいるらしい
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getProductsQuery()
    {
        return DB::table('products')
            ->leftJoin('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name')
            ->orderBy('products.created_at', 'desc');
    }

    public function registProduct($data,$imagePath) //$imagePath追加
    {
        DB::table('products')->insert([
            'company_id' => $data['company_id'],
            'product_name' => $data['product_name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'comment' => $data['comment'],
            'img_path' => $imagePath,
        ]);
    } 

    public function deleteProduct()
    {
        DB::table('products')->where('id', $this->id)->delete();
    }
}
