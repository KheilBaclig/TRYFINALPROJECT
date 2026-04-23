<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use CodeIgniter\Images\Handlers\BaseHandler;

class Products extends BaseController
{
    protected ProductModel $model;
    protected ProductVariantModel $variantModel;

    public function __construct()
    {
        $this->model        = new ProductModel();
        $this->variantModel = new ProductVariantModel();
    }

    public function index(): string
    {
        $search   = $this->request->getGet('search');
        $category = $this->request->getGet('category');

        $builder = $this->model->withCategory();
        if ($search)   $builder->like('products.name', $search);
        if ($category) $builder->where('products.category_id', $category);

        $pager    = service('pager');
        $page     = (int) ($this->request->getGet('page') ?? 1);
        $perPage  = 10;
        $total    = $builder->countAllResults(false);
        $products = $builder->orderBy('products.created_at', 'DESC')->paginate($perPage, 'default', $page);

        $categories = (new CategoryModel())->findAll();
        $pager      = $this->model->pager;

        return $this->render('products/index', compact('products', 'categories', 'pager', 'search', 'category', 'total'));
    }

    public function new(): string
    {
        $categories = (new CategoryModel())->findAll();
        return $this->render('products/form', ['product' => null, 'categories' => $categories]);
    }

    public function create()
    {
        if (! $this->validate($this->model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = url_title($this->request->getPost('name'), '-', true);
        $data = [
            'category_id' => (int) $this->request->getPost('category_id'),
            'name'        => esc($this->request->getPost('name')),
            'slug'        => $slug,
            'sku'         => strtoupper(esc($this->request->getPost('sku'))),
            'description' => esc($this->request->getPost('description')),
            'price'       => (float) $this->request->getPost('price'),
            'is_active'   => 1,
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/products', $newName);

            // Image manipulation — resize to 800x800
            service('image')
                ->withFile(ROOTPATH . 'public/uploads/products/' . $newName)
                ->fit(800, 800, 'center')
                ->save(ROOTPATH . 'public/uploads/products/' . $newName);

            $data['image'] = $newName;
        }

        try {
            $inserted = $this->model->insert($data);
            
            if ($inserted) {
                return redirect()->to('/products')->with('success', 'Product created successfully.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create product.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Product create exception: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function show($id): string
    {
        $product  = $this->model->withCategory()->find($id);
        if (! $product) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $variants = $this->variantModel->where('product_id', $id)->findAll();
        return $this->render('products/show', compact('product', 'variants'));
    }

    public function edit($id): string
    {
        $product    = $this->model->find($id);
        if (! $product) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $categories = (new CategoryModel())->findAll();
        return $this->render('products/form', compact('product', 'categories'));
    }

    public function update($id)
    {
        $product = $this->model->find($id);
        if (! $product) {
            return redirect()->to('/products')->with('error', 'Product not found.');
        }

        $rules = [
            'name'        => 'required|min_length[2]|max_length[200]',
            'sku'         => "required|is_unique[products.sku,id,{$id}]",
            'price'       => 'required|numeric|greater_than[0]',
            'category_id' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'category_id' => (int) $this->request->getPost('category_id'),
            'name'        => esc($this->request->getPost('name')),
            'slug'        => url_title($this->request->getPost('name'), '-', true),
            'sku'         => strtoupper(esc($this->request->getPost('sku'))),
            'description' => esc($this->request->getPost('description')),
            'price'       => (float) $this->request->getPost('price'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/products', $newName);
            service('image')
                ->withFile(ROOTPATH . 'public/uploads/products/' . $newName)
                ->fit(800, 800, 'center')
                ->save(ROOTPATH . 'public/uploads/products/' . $newName);
            $data['image'] = $newName;
        }

        try {
            // Use builder to force update
            $this->model->builder()->where('id', $id)->update($data);
            return redirect()->to('/products')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            log_message('error', 'Product update exception: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $product = $this->model->find($id);
        if (! $product) {
            return redirect()->to('/products')->with('error', 'Product not found.');
        }
        
        $deleted = $this->model->delete($id);
        
        if ($deleted) {
            return redirect()->to('/products')->with('success', 'Product deleted successfully.');
        } else {
            return redirect()->to('/products')->with('error', 'Failed to delete product.');
        }
    }

    public function variants($productId): string
    {
        $product  = $this->model->find($productId);
        $variants = $this->variantModel->where('product_id', $productId)->findAll();
        return $this->render('products/variants', compact('product', 'variants'));
    }

    public function storeVariant($productId)
    {
        if (! $this->validate($this->variantModel->validationRules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->variantModel->insert([
            'product_id' => $productId,
            'size'       => $this->request->getPost('size'),
            'color'      => esc($this->request->getPost('color')),
            'color_hex'  => $this->request->getPost('color_hex'),
            'stock'      => (int) $this->request->getPost('stock'),
        ]);

        return redirect()->back()->with('success', 'Variant added.');
    }

    public function deleteVariant($variantId)
    {
        $variant = $this->variantModel->find($variantId);
        $this->variantModel->delete($variantId);
        return redirect()->to("/products/{$variant['product_id']}/variants")->with('success', 'Variant deleted.');
    }
}
