<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $this->authorize('view');
        $users = $this->userRepository->datatables();
        $roles = Role::all();

        if (request()->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', 'admin.datatables.action')
                ->make(true);
        }

        return view('admin.user.index', compact('roles'));
    }


    public function store(UserRequest $request)
    {
        $this->authorize('create');

        $image = $request->file('avatar');

        $form_data = [
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'birthday' => $request->input('birthday'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id'),
            'address' => $request->input('address'),
        ];

        if ($image) {
            $new_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images/users'), $new_name);
            $form_data['avatar'] = $new_name;
        }

        $this->userRepository->create($form_data);

        $data = [
            'success' => 'Thêm thành công.'
        ];

        return $data;
    }


    public function edit($id)
    {
        $this->authorize('update');

        $product = $this->userRepository->find($id);

        return $product;
    }


    public function update(UserRequest $request)
    {
        $this->authorize('create');
        $id = $request->input('hidden_id');
        $image = $request->file('avatar');
        $password = $request->input('password');

        $form_data = [
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'birthday' => $request->input('birthday'),
            'role_id' => $request->input('role_id'),
            'address' => $request->input('address'),
        ];

        if ($image) {
            $new_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images/users'), $new_name);
            $form_data['avatar'] = $new_name;
        }

        if ($password) {
            $form_data['password'] = Hash::make($request->input('password'));
        }

        $this->userRepository->update($id, $form_data);

        $data = [
            'success' => 'Cập nhật thành công.'
        ];

        return $data;
    }

    public function destroy($id)
    {
        $this->authorize('delete');

        $data = $this->userRepository->find($id);
        $data->delete();

        $data = [
            'success' => 'Xóa thành công.'
        ];

        return $data;
    }
}
