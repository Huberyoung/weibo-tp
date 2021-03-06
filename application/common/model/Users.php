<?php

namespace app\common\model;

use think\Model;
use app\common\model\Followers;

class Users extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    public function statuses()
    {
        return $this->hasMany('Statuses','user_id');
    }

    public function feed()
    {
        $user_ids =  Followers::where(['user_id'=>$this->id])->column('follower_id');
        array_push($user_ids,$this->id);
        $statuses = Statuses::where('user_id','in',$user_ids)->order('created_at','desc');

        return $statuses;
    }

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->email)));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public function followers()
    {
        return $this->belongsToMany('Users','followers','user_id','follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany('Users','followers','follower_id','user_id');
    }

    public function follow($user_ids)
    {
        $this->followings()->attach($user_ids);
    }

    public function unFollow($user_ids)
    {
        $this->followings()->detach($user_ids);
    }

    public function isFollowing($user_id)
    {
        $followers = Followers::where(['user_id'=>$this->id,'follower_id'=>$user_id])->findOrEmpty();

        return isset($followers->id);
    }
}
