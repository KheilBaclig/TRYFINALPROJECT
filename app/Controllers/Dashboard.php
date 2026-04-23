<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use App\Models\ProductVariantModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $role = session()->get('user_role');

        if ($role === 'superadmin') return $this->superadminDashboard();
        if ($role === 'manager')    return $this->managerDashboard();
        return $this->staffDashboard();
    }

    private function superadminDashboard(): string
    {
        $productModel     = new ProductModel();
        $transactionModel = new TransactionModel();
        $userModel        = new UserModel();
        $variantModel     = new ProductVariantModel();

        $totalProducts = $productModel->countAllResults();
        $totalStock    = $variantModel->selectSum('stock')->first()['stock'] ?? 0;
        $totalSales    = $transactionModel->where('type', 'sale')->countAllResults();
        $totalUsers    = $userModel->countAllResults();
        $totalReturns  = $transactionModel->where('type', 'return')->countAllResults();
        $totalRevenue  = $transactionModel->where('type', 'sale')->selectSum('total')->first()['total'] ?? 0;

        $recentTx = $transactionModel->withUser()->orderBy('transactions.created_at', 'DESC')->limit(5)->find();

        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date        = date('Y-m-d', strtotime("-{$i} days"));
            $salesData[] = [
                'date'  => date('M d', strtotime($date)),
                'total' => (float) ($transactionModel->where('type', 'sale')->where('DATE(created_at)', $date)->selectSum('total')->first()['total'] ?? 0),
            ];
        }

        $lowStock = $variantModel
            ->select('product_variants.*, products.name as product_name, products.sku')
            ->join('products', 'products.id = product_variants.product_id')
            ->where('product_variants.stock <=', 5)
            ->orderBy('product_variants.stock', 'ASC')
            ->limit(5)->find();

        $recentUsers = $userModel->orderBy('created_at', 'DESC')->limit(5)->find();

        return $this->render('dashboard/superadmin', compact(
            'totalProducts', 'totalStock', 'totalSales', 'totalUsers',
            'totalReturns', 'totalRevenue', 'recentTx', 'salesData', 'lowStock', 'recentUsers'
        ));
    }

    private function managerDashboard(): string
    {
        $productModel     = new ProductModel();
        $transactionModel = new TransactionModel();
        $variantModel     = new ProductVariantModel();

        $totalProducts = $productModel->countAllResults();
        $totalStock    = $variantModel->selectSum('stock')->first()['stock'] ?? 0;
        $totalSales    = $transactionModel->where('type', 'sale')->countAllResults();
        $totalReturns  = $transactionModel->where('type', 'return')->countAllResults();
        $totalRevenue  = $transactionModel->where('type', 'sale')->selectSum('total')->first()['total'] ?? 0;

        $recentTx = $transactionModel->withUser()->orderBy('transactions.created_at', 'DESC')->limit(8)->find();

        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date        = date('Y-m-d', strtotime("-{$i} days"));
            $salesData[] = [
                'date'  => date('M d', strtotime($date)),
                'sales' => (float) ($transactionModel->where('type', 'sale')->where('DATE(created_at)', $date)->selectSum('total')->first()['total'] ?? 0),
                'returns' => (float) ($transactionModel->where('type', 'return')->where('DATE(created_at)', $date)->selectSum('total')->first()['total'] ?? 0),
            ];
        }

        $lowStock = $variantModel
            ->select('product_variants.*, products.name as product_name, products.sku')
            ->join('products', 'products.id = product_variants.product_id')
            ->where('product_variants.stock <=', 5)
            ->orderBy('product_variants.stock', 'ASC')
            ->limit(8)->find();

        return $this->render('dashboard/manager', compact(
            'totalProducts', 'totalStock', 'totalSales', 'totalReturns',
            'totalRevenue', 'recentTx', 'salesData', 'lowStock'
        ));
    }

    private function staffDashboard(): string
    {
        $productModel  = new ProductModel();
        $variantModel  = new ProductVariantModel();
        $categoryModel = new CategoryModel();

        $totalProducts  = $productModel->countAllResults();
        $totalStock     = $variantModel->selectSum('stock')->first()['stock'] ?? 0;
        $totalCategories = $categoryModel->countAllResults();

        $lowStock = $variantModel
            ->select('product_variants.*, products.name as product_name, products.sku')
            ->join('products', 'products.id = product_variants.product_id')
            ->where('product_variants.stock <=', 5)
            ->orderBy('product_variants.stock', 'ASC')
            ->limit(5)->find();

        $recentProducts = $productModel->withCategory()->orderBy('products.created_at', 'DESC')->limit(6)->find();

        $stockByCategory = $categoryModel
            ->select('categories.name, SUM(product_variants.stock) as total_stock')
            ->join('products', 'products.category_id = categories.id', 'left')
            ->join('product_variants', 'product_variants.product_id = products.id', 'left')
            ->groupBy('categories.id')
            ->findAll();

        return $this->render('dashboard/staff', compact(
            'totalProducts', 'totalStock', 'totalCategories',
            'lowStock', 'recentProducts', 'stockByCategory'
        ));
    }

    public function profile(): string
    {
        $user = (new UserModel())->find(session()->get('user_id'));
        return $this->render('dashboard/profile', compact('user'));
    }

    public function updateProfile()
    {
        $userId = session()->get('user_id');
        $model  = new UserModel();

        if (! $this->validate(['name' => 'required|min_length[2]'])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = ['name' => esc($this->request->getPost('name'))];

        $file = $this->request->getFile('avatar');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/avatars', $newName);
            $data['avatar'] = $newName;
            session()->set('user_avatar', $newName);
        }

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $model->update($userId, $data);
        session()->set('user_name', $data['name']);

        return redirect()->to('/profile')->with('success', 'Profile updated.');
    }
}
