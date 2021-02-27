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
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

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

    public static function record_user_search($query, $user_id) {
        return DB::table(self::TABLE_NAME)->insert([
            'query' => $query,
            'user_id' => $user_id,
            'date' => date('Y-m-d H:i:s')
        ]);
    }


}
