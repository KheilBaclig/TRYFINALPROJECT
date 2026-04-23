<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected CategoryModel $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function index(): string
    {
        $categories = $this->model->paginate(10);
        $pager      = $this->model->pager;
        return $this->render('categories/index', compact('categories', 'pager'));
    }

    public function new(): string
    {
        return $this->render('categories/form', ['category' => null]);
    }

    public function create()
    {
        if (! $this->validate($this->model->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'name'        => esc($this->request->getPost('name')),
            'slug'        => url_title($this->request->getPost('name'), '-', true),
            'description' => esc($this->request->getPost('description')),
        ]);

        return redirect()->to('/categories')->with('success', 'Category created.');
    }

    public function edit($id): string
    {
        $category = $this->model->find($id);
        return $this->render('categories/form', compact('category'));
    }

    public function update($id)
    {
        $category = $this->model->find($id);
        if (! $category) {
            return redirect()->to('/categories')->with('error', 'Category not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'slug' => "required|is_unique[categories.slug,id,{$id}]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'        => esc($this->request->getPost('name')),
            'slug'        => url_title($this->request->getPost('name'), '-', true),
            'description' => esc($this->request->getPost('description')),
        ];

        try {
            $this->model->builder()->where('id', $id)->update($data);
            return redirect()->to('/categories')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/categories')->with('success', 'Category deleted.');
    }
}
