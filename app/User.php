<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
use Log;

class User extends Authenticatable
{
    /**
     * Model for the `users` table in the Database. Most functions here should be
     * self-explanatory
     */


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
        $ret = DB::table(self::TABLE_NAME)->insert([
            'username' => $params['username'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT),
            'email' => $params['email'],
            'admin' => '0',
            'verify_token' => $verify_token,
            'verified' => '0',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if ($ret) {
            return $verify_token;
        }
        return false;
    }

    public static function delete_last_user() {
        DB::table(self::TABLE_NAME)->orderBy('id', 'desc')
            ->limit(1)
            ->delete();
    }

    public static function verify_user($email, $token)  {

        if (!self::email_exists($email)) {
            Log::warning("Email supplied to verify_user() does not exist");
            return [false, "Invalid email"];
        }
        $user = User::find(DB::table(self::TABLE_NAME)->where('email', $email)->first()->id);
        if ($user->verify_token !== $token) {
            Log::warning("Token supplied to verify_user() does not match");
            return [false, "Invalid token"];
        }

        if ($user->verified == '1') {
            Log::warning("User already verified!");
            return [false, "User already verified"];
        }

        $user->verified = '1';
        $user->save();
        return true;
    }

    public static function update_password($password) {
        return DB::table(self::TABLE_NAME)->update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}
