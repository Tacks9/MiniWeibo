<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class SessionsController extends Controller
{

    public function __construct()
    {
        // 只让未登录用户访问注册页面
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);
        // 只让未登录用户访问登录页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    // 登录页面
    public function create()
    {
        return view('sessions.create');
    }

    // 登录认证
    public function store(Request $request)
    {
        // 参数验证
        $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);
        // 用户名密码比对
         if (Auth::attempt($credentials,$request->has('remember'))) {
            // 判断是否激活
             if(Auth::user()->activated) {
                   // 登录成功后的相关操作
                    session()->flash('success', '欢迎回来！');
                    $fallback = route('users.show', [Auth::user()]);
                    return redirect()->intended($fallback);
            }else{
                Auth::logout();
               session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
               return redirect('/');
            }
        } else {
           // 登录失败后的相关操作
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }


        return ;
    }

    // 退出
    public function destroy()
    {
        Auth::logout();
        session()->flash('success',' 您已经成功退出啦的 (￣▽￣)"');
        return redirect('login');
    }
}
