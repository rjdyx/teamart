<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at
    protected $table = 'user';

    const AVATAR = '/../upload/avatar/';
    const TYPE_USER = 0;
    const TYPE_DISTRIBUTOR = 1;
    const TYPE_ADMIN = 2;
    const TYPE = [
        self::TYPE_USER => '用户',
        self::TYPE_DISTRIBUTOR => '分销商',
        self::TYPE_ADMIN => '管理员',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','grade','parter_id','img','thumb','realname','openid','gender'
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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
