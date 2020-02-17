<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        if (request()->ajax()) {
            return datatables()->of($products)
                ->addColumn('action', 'admin.datatables.action')
                ->make(true);
        }

        return view('admin.product.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ProductRequest $request
     * @return mixed
     */
    public function store(ProductRequest $request)
    {
        $image = $request->file('avatar');
        $form_data = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
        ];

        if ($image) {
            $new_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images/products'), $new_name);
            $form_data['avatar'] = $new_name;
        }

        $this->productRepository->create($form_data);

        $data = [
            'success' => 'Thêm thành công.'
        ];

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ProductRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(ProductRequest $request)
    {

        $id = $request->input('hidden_id');
        $image = $request->file('avatar');

        $form_data = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
        ];

        if ($image) {
            $new_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images/products'), $new_name);
            $form_data['avatar'] = $new_name;
        }

        $this->productRepository->update($id, $form_data);

        $data = [
            'success' => 'Thêm thành công.'
        ];

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = $this->productRepository->find($id);
        $data->delete();

        $data = [
            'success' => 'Xóa thành công.'
        ];

        return $data;
    }
}
