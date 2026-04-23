<?php

namespace App\Controllers\Api;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use CodeIgniter\RESTful\ResourceController;

class ProductsApi extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $cache = cache();
        $key   = 'api_products_' . md5(json_encode($this->request->getGet()));

        if ($cached = $cache->get($key)) {
            return $this->respond($cached);
        }

        $model    = new ProductModel();
        $search   = $this->request->getGet('search');
        $category = $this->request->getGet('category_id');
        $page     = (int) ($this->request->getGet('page') ?? 1);
        $perPage  = (int) ($this->request->getGet('per_page') ?? 15);

        $builder = $model->withCategory()->where('products.is_active', 1);
        if ($search)   $builder->like('products.name', $search);
        if ($category) $builder->where('products.category_id', $category);

        $total    = $builder->countAllResults(false);
        $products = $builder->paginate($perPage, 'default', $page);

        foreach ($products as &$p) {
            $p['total_stock'] = $model->getTotalStock($p['id']);
        }

        $response = [
            'status' => 'success',
            'data'   => $products,
            'meta'   => ['total' => $total, 'page' => $page, 'per_page' => $perPage],
        ];

        $cache->save($key, $response, 300); // 5 min cache
        return $this->respond($response);
    }

    public function show($id = null)
    {
        $model   = new ProductModel();
        $product = $model->withCategory()->find($id);

        if (! $product) {
            return $this->failNotFound('Product not found.');
        }

        $variants = (new ProductVariantModel())->where('product_id', $id)->findAll();
        $product['variants']    = $variants;
        $product['total_stock'] = array_sum(array_column($variants, 'stock'));

        return $this->respond(['status' => 'success', 'data' => $product]);
    }

    public function stock($id = null)
    {
        $model   = new ProductModel();
        $product = $model->find($id);

        if (! $product) {
            return $this->failNotFound('Product not found.');
        }

        $variants = (new ProductVariantModel())->where('product_id', $id)->findAll();
        $stock    = [];

        foreach ($variants as $v) {
            $stock[] = [
                'variant_id' => $v['id'],
                'size'       => $v['size'],
                'color'      => $v['color'],
                'color_hex'  => $v['color_hex'],
                'stock'      => $v['stock'],
            ];
        }

        return $this->respond([
            'status'      => 'success',
            'product_id'  => (int) $id,
            'product_name'=> $product['name'],
            'sku'         => $product['sku'],
            'total_stock' => array_sum(array_column($variants, 'stock')),
            'variants'    => $stock,
        ]);
    }

    public function categories()
    {
        $cache = cache();
        if ($cached = $cache->get('api_categories')) {
            return $this->respond($cached);
        }

        $categories = (new CategoryModel())->findAll();
        $response   = ['status' => 'success', 'data' => $categories];
        $cache->save('api_categories', $response, 600);

        return $this->respond($response);
    }
}
