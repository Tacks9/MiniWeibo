<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Auth;

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
        //注册成功自动登录
        Auth::login($user);

        // 保存会话
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        // 路由跳转 绑定数据
        return redirect()->route('users.show',[$user]);
    }

    // 用户编辑页面
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    // 用户进行编辑
    public function update(User $user,Request $request)
    {
        // 数据验证
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6' // 密码为空也可以
        ]);
        // 数据进行更新
        $data           = [];
        $data['name']   = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success', '个人资料更新成功！');
        // 重定向
        return redirect()->route('users.show',$user);
    }
}
