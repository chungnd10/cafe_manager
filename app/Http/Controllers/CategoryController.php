<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-categories');

        if (request()->ajax()) {
            return datatables()->of(Category::latest()->get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button"
                                        name="edit" 
                                        id="' . $data->id. '" 
                                        class="edit btn btn-warning btn-sm">
                                   <i class="fa fa-pencil"></i>
                                   &nbsp;&nbsp;Sửa
                               </button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" 
                                    name="delete" 
                                    id="' . $data->id . '" 
                                    class="delete btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                    &nbsp;&nbsp;Xóa
                                </button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.category.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->authorize('create-categories');

        $category = [
            'name' => $request->name
        ];

        Category::create($category);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-categories');
        $category = Category::findOrFail($id);
        return response()->json(['data' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request)
    {
        $this->authorize('update-categories');

        $id = $request->hidden_id;

        $form_data = [
            "name" => $request->name
        ];

        Category::whereId($id)->update($form_data);
        return response()->json(['success'=>'Update successfuly.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-categories');

        $data = Category::findOrFail($id);
        $data->delete();

        return response()->json('Delele successfuly.');
    }
}
