<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use App\Models\TransactionItemModel;
use App\Models\TransactionModel;

class Transactions extends BaseController
{
    protected TransactionModel $model;

    public function __construct()
    {
        $this->model = new TransactionModel();
    }

    public function index(): string
    {
        $type = $this->request->getGet('type');
        $builder = $this->model->withUser();
        if ($type) $builder->where('transactions.type', $type);

        $transactions = $builder->orderBy('transactions.created_at', 'DESC')->paginate(10);
        $pager        = $this->model->pager;

        return $this->render('transactions/index', compact('transactions', 'pager', 'type'));
    }

    public function new(): string
    {
        $products = (new ProductModel())->withCategory()->where('is_active', 1)->findAll();
        $variants = (new ProductVariantModel())->where('stock >', 0)->findAll();
        return $this->render('transactions/form', compact('products', 'variants'));
    }

    public function create()
    {
        $variantIds = $this->request->getPost('variant_id');
        $quantities = $this->request->getPost('quantity');
        $type       = $this->request->getPost('type') ?? 'sale';

        if (empty($variantIds)) {
            return redirect()->back()->with('error', 'Add at least one item.');
        }

        $variantModel = new ProductVariantModel();
        $itemModel    = new TransactionItemModel();
        $total        = 0;
        $items        = [];

        foreach ($variantIds as $i => $variantId) {
            $qty     = (int) $quantities[$i];
            $variant = $variantModel->select('product_variants.*, products.price')
                ->join('products', 'products.id = product_variants.product_id')
                ->find($variantId);

            if (! $variant || ($type === 'sale' && $variant['stock'] < $qty)) {
                return redirect()->back()->with('error', "Insufficient stock for variant #{$variantId}.");
            }

            $subtotal = $variant['price'] * $qty;
            $total   += $subtotal;
            $items[]  = ['variant_id' => $variantId, 'quantity' => $qty, 'unit_price' => $variant['price']];
        }

        $txId = $this->model->insert([
            'ref_code' => $this->model->generateRef(),
            'type'     => $type,
            'user_id'  => session()->get('user_id'),
            'total'    => $total,
            'notes'    => esc($this->request->getPost('notes')),
        ]);

        foreach ($items as $item) {
            $item['transaction_id'] = $txId;
            $itemModel->insert($item);
            $variantModel->adjustStock($item['variant_id'], $item['quantity'], $type);
        }

        return redirect()->to('/transactions')->with('success', 'Transaction recorded.');
    }

    public function show($id): string
    {
        $transaction = $this->model->withUser()->find($id);
        if (! $transaction) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $items = (new TransactionItemModel())
            ->select('transaction_items.*, product_variants.size, product_variants.color, product_variants.color_hex, products.name as product_name, products.sku')
            ->join('product_variants', 'product_variants.id = transaction_items.variant_id')
            ->join('products', 'products.id = product_variants.product_id')
            ->where('transaction_id', $id)
            ->findAll();

        return $this->render('transactions/show', compact('transaction', 'items'));
    }
}
