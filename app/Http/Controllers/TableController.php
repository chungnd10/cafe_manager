<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Repositories\Table\TableRepository;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected $tableRepository;
    public function __construct(TableRepository $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view');

        $tables = $this->tableRepository->datatables();

        if (request()->ajax()) {
            return datatables()->of($tables)
                ->addColumn('action','admin.datatables.action')
                ->make(true);
        }
        return view('admin.table.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(TableRequest $request)
    {
        $this->authorize('create');

        $table_status_id = config('constants.TABLE_STATUS_EMPTY');
        $form_data = [
            'name' => $request->input('name'),
            'number_of_seats' =>$request->input('number_of_seats'),
            'table_status_id' => $table_status_id
        ];

        $this->tableRepository->create($form_data);

        $data = [
            'success' => 'Thêm thành công.'
        ];

        return $data;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update');

        $table = $this->tableRepository->find($id);

        return $table;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(TableRequest $request)
    {
        $this->authorize('update');

        $id = $request->input('hidden_id');

        $form_data = [
            'name' => $request->input('name'),
            'number_of_seats' =>$request->input('number_of_seats')
        ];

        $this->tableRepository->update($id, $form_data);

        $data = [
            'success' => 'Cập nhật thành công.'
        ];

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->authorize('delete');

        $table = $this->tableRepository->find($id);
        $table->delete();

        $data = [
            'success' => 'Xóa thành công.'
        ];

        return $data;
    }
}
