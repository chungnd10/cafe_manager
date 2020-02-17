<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        $roles = $this->roleRepository->getAll();

        if (request()->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', 'admin.datatables.action')
                ->make(true);
        }

        return view('admin.user.index', compact('roles'));
    }


    public function store(UserRequest $request)
    {
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
        $product = $this->userRepository->find($id);
        return $product;
    }


    public function update(UserRequest $request)
    {
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
        $data = $this->userRepository->find($id);
        $data->delete();

        $data = [
            'success' => 'Xóa thành công.'
        ];

        return $data;
    }
}
