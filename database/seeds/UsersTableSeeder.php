<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // times 接受一个参数用于指定要创建的模型数量
        // make 方法调用后将为模型创建一个 集合
        $users = factory(User::class)->times(50)->make();
        // makeVisible 方法临时显示 User 模型里指定的隐藏属性 $hidden
        // insert 方法来将生成假用户列表数据批量插入到数据库中
        User::insert($users->makeVisible(['password','remeber_token'])->toArray());

        // 最后我们还对第一位用户的信息进行了更新，方便后面我们使用此账号登录
        $user        = User::find(1);
        $user->name  = 'tacks';
        $user->email = 'tacks@qq.com';
        $user->is_admin = true; // 第一个管理员
        $user->save();
    }
}
