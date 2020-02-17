<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getAll();

        if (request()->ajax()) {
            return datatables()->of($categories)
                ->addColumn('action','admin.datatables.action')
                ->make(true);
        }
        return view('admin.category.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CategoryRequest $request
     * @return mixed
     */
    public function store(CategoryRequest $request)
    {
        $form_data = [
            'name' => $request->input('name')
        ];

        $this->categoryRepository->create($form_data);

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
        $category = $this->categoryRepository->find($id);

        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return mixed
     */
    public function update(CategoryRequest $request)
    {
        $id = $request->input('hidden_id');

        $form_data = [
            'name' => $request->input('name')
        ];

        $this->categoryRepository->update($id, $form_data);

        $data = [
            'success' => 'Cập nhật thành công.'
        ];

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);
        $category->delete();

        $data = [
            'success' => 'Xóa thành công.'
        ];

        return $data;
    }
}
