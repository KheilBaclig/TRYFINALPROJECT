<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table          = 'products';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $allowedFields  = ['category_id', 'name', 'slug', 'sku', 'description', 'price', 'image', 'is_active'];

    protected $validationRules = [
        'name'        => 'required|min_length[2]|max_length[200]',
        'sku'         => 'required|is_unique[products.sku,id,{id}]',
        'price'       => 'required|numeric|greater_than[0]',
        'category_id' => 'required|integer',
    ];

    public function withCategory(): static
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id');
    }

    public function getTotalStock(int $productId): int
    {
        return (int) (new ProductVariantModel())
            ->where('product_id', $productId)
            ->selectSum('stock')
            ->first()['stock'] ?? 0;
    }
}
