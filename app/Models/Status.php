<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // 允许更新
    protected $fillable = ['content'];

    // 用于 与 微博 一对多
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
