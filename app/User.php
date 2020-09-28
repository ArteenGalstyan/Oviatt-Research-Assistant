<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
use mysql_xdevapi\Exception;

class User extends Authenticatable
{
    use Notifiable;
    const TABLE_NAME = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'username', 'password', 'email', 'admin', 'rememeber_token', 'verify_token', 'verified', 'created_at'
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


    public static function user_exists($username) {
        return DB::table(self::TABLE_NAME)->where('username', $username)->first();
    }

    public static function email_exists($email) {
        return DB::table(self::TABLE_NAME)->where('email', $email)->first();
    }

    public static function create_user($params) {
        if (!(
            isset($params['username']) &&
            isset($params['password']) &&
            isset($params['email'])
        )) {
            return false;
        }
        $verify_token = uniqid() . uniqid();
        DB::table(self::TABLE_NAME)->insert([
            'username' => $params['username'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT),
            'email' => $params['email'],
            'admin' => '0',
            'verify_token' => $verify_token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return $verify_token;
    }
}
