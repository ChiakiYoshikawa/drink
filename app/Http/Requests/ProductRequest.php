<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name'=>'required|max:20',
            'price'=>'required|integer',
            'stock'=>'required|integer',
            'company_id'=>'required',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'comment' => 'nullable|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'product_name'=>'商品名',
            'price'=>'価格',
            'stock'=>'在庫数',
            'company_id'=>'メーカー名',
            'img_path' => '画像',
            'comment' => 'コメント',
        ];
    }

    public function messages() {
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'price.required' => ':attributeは必須項目です。',
            'price.integer' => ':attributeは半角数字で入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.integer'=> ':attributeは半角数字で入力してください。',
            'company_id.required' => ':attributeは必須項目です。',
            'img_path.image' => '画像ファイルをアップロードしてください。',
            'img_path.mimes' => '画像ファイルはjpeg、png、jpg、gif形式のみ対応しています。',
            'img_path.max' => '画像サイズは2MB以下にしてください。',
            'comment.max' => 'コメントは:max文字以内で入力してください。',
        ];
    }
}
