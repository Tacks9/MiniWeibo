<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // 获取头像 gravatar
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }


    public static function boot()
    {
        // 用户模型类完成初始化之后进行加载
        parent::boot();
        // 监听模型被创建之前的事件
        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    // 用户 与 微博 一对多
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    // 微博内容流
    public function feed()
    {
        return $this->statuses()
                    ->orderBy('created_at', 'desc');
    }


    // 多对多
    // 粉丝关系列表
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }

    // 关注人列表
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }


    // 关注
    public function follow($user_ids)
    {
        if( !is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids,false);
    }

    // 取消关注
    public function unfollow($user_ids)
    {
        if( !is_array($user_ids)) {
            // 不是数组 要转化一下
            $user_ids = compact('user_ids');
        }
        // 自动获取数组中的id
        $this->followings()->detach($user_ids);
    }

    // 判断是否关注某人
    public function isFollowing($user_id)
    {
        // 使用contains 判断是否在关注列表中
        return $this->followings->contains($user_id);
    }

}
