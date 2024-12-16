<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{LoginRequest, RegisterRequest, UpdateUserRequest};
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function allUsers()
    {
        $users = User::all();
        return view('admin.trashed.index',compact('users'));
    }
    public function createUser(RegisterRequest $request)
    {
        $data = $request->validated();
        $admin = User::create($data);
        return redirect()->route('users.index')->with('success','تم إضافةالموظف بنجاح');
    }
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.trashed.users.show',compact('user'));
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.trashed.users.edit',compact('user'));
    }
    public function updateUser(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        $user = User::findOrFail($id);
        if($user->role == 'owner' && $data['role'] != 'owner')
        {
            return redirect()->back()->with('error','لا يمكن تغيير صلاحيات المالك');
        }
        $user->update($data);
        return redirect()->route('users.index')->with('success','User updated successfully');
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $admin = User::Where('phone',$data['email'])
        ->first();
        if(!$admin || !Hash::check($request->password,$admin->password))
        {
            return redirect()->back()->with('error','Invalid Credentials');
        }
        auth()->login($admin);
        return redirect()->route('admin.index');
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login.view');
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        try {
            if($user->id == auth()->id())
            {
                return response()->json(['status' => 'error', 'message' => 'You cannot delete yourself']);
            }
            elseif($user->role == 'owner')
            {
                return response()->json(['status' => 'error', 'message' => 'You cannot delete an owner']);
            }
            $user->delete();
            return response()->json(['status' => 'success', 'message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'User cannot be deleted']);
        }
    }
}
