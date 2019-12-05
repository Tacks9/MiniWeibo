<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Auth;
use Mail;

class UsersController extends Controller
{
    // 构造方法
    public function __construct()
    {
        // 中间件：不需要登录也可以进行访问的页面
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store','index','confirmEmail']
        ]);
    }

    // 全部用户列表
    public function index()
    {
        // $users = User::all();
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }


    // 用户注册
    public function create()
    {
        return view('users.create');
    }

    // 显示用户 微博
    public function show(User $user)
    {
         $statuses = $user->statuses()
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);
        return view('users.show', compact('user', 'statuses'));
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
         // 发送验证
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
        //注册成功自动登录
        //Auth::login($user);
        // 保存会话
        //session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        // 路由跳转 绑定数据
        // return redirect()->route('users.show',[$user]);
    }

    // 用户编辑页面
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    // 用户进行编辑
    public function update(User $user,Request $request)
    {
        // 授权验证
        $this->authorize('update', $user);
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

    // 用户删除
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success','成功删除用户！ ');
        return back();
    }

    // 激活发送邮件
    public function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'summer@example.com';
        $name = 'Summer';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";
         Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    // 验证邮件
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }
}
