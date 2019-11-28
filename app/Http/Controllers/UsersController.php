<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    // 用户注册
    public function create()
    {
        return view('users.create');
    }

    // 显示用户
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    // 注册提交
    public function store(Request $request)
    {
        // 验证字段
        $this->validate($request ,[
            'name'      => 'required|max:50',
            'email'     => 'required|email|unique:users|max:255',
            'password'  => 'required|confirmed|min:6'
        ]);

        // 写入数据库
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        // 保存会话
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        // 路由跳转 绑定数据
        return redirect()->route('users.show',[$user]);
    }
}
