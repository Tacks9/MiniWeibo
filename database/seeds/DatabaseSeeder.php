<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Model::unguard();
        // 指定我们要运行假数据填充的文件
        $this->call(UsersTableSeeder::class);
        // 微博数据填充文件
        $this->call(StatusesTableSeeder::class);
        Model::reguard();
    }
}
