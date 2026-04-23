<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table         = 'product_variants';
    protected $useTimestamps = true;
    protected $allowedFields = ['product_id', 'size', 'color', 'color_hex', 'stock'];

    protected $validationRules = [
        'product_id' => 'required|integer',
        'size'       => 'required|max_length[20]',
        'color'      => 'required|max_length[50]',
        'stock'      => 'required|integer|greater_than_equal_to[0]',
    ];

    public function adjustStock(int $variantId, int $qty, string $type = 'sale'): bool
    {
        $variant = $this->find($variantId);
        if (! $variant) return false;

        $newStock = $type === 'return'
            ? $variant['stock'] + $qty
            : $variant['stock'] - $qty;

        return $this->update($variantId, ['stock' => max(0, $newStock)]);
    }
}
