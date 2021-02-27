<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class SearchHistory extends Model
{
    /**
     * Model for the `users` table in the Database. Most functions here should be
     * self-explanatory
     */


    use Notifiable;
    const TABLE_NAME = 'search_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'query', 'user_id', 'date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    public static function get_user_history($user_id) {
        return DB::table(self::TABLE_NAME)->where('user_id', $user_id)->get()->toArray();
    }

    public static function delete_query_history($id) {
        return DB::table(self::TABLE_NAME)->where('id', $id)->delete();
    }



}
