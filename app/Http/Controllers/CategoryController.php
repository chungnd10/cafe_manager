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
        $this->authorize('view');

        $categories = $this->categoryRepository->orderBy('id', 'desc');

        if (request()->ajax()) {
            return datatables()->of($categories)
                ->addColumn('action','admin.category.datatables.action')
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
        $this->authorize('create');

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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update');

        $category = $this->categoryRepository->find($id);

        return response()->json(['data' => $category]);
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
        $this->authorize('update');

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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete');

        $data = $this->categoryRepository->find($id);
        $data->delete();

        $data = [
            'success' => 'Xóa thành công.'
        ];

        return $data;
    }
}
