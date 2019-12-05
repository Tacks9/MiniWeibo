<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    //
    public function __construct()
    {
        // 中间件 验证用户登录
        $this->middleware('auth');
    }

    // 发布微博
    public function store(Request $request)
    {
        // 验证  一条微博的最长长度为 140 个字符
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        // 创建微博
        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '发布成功！');
        // 网站主页
        return redirect()->back();
    }

    // 删除微博
    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
