<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class FavoriteArticles extends Model
{
    /**
     * Model for the `users` table in the Database. Most functions here should be
     * self-explanatory
     */


    use Notifiable;
    const TABLE_NAME = 'favorite_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'article_id', 'user_id', 'date'
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

    public static function get_user_favorites($user_id)
    {
        return DB::table(self::TABLE_NAME)->where('user_id', $user_id)->get()->toArray();
    }

    public static function favorite_article($article_id, $user_id)
    {
        if (self::is_favorited($article_id, $user_id)) {
            return true;
        }
        return DB::table(self::TABLE_NAME)->insert([
            'article_id' => $article_id,
            'user_id' => $user_id,
            'date' => date('Y-m-d H:i:s')
        ]);
    }

    public static function unfavorite_article($article_id, $user_id) {
        if (self::is_favorited($article_id, $user_id)) {
            return true;
        }
        return DB::table(self::TABLE_NAME)
            ->where('article_id', $article_id)
            ->where('user_id', $user_id)
            ->delete();
    }

    public static function is_favorited($article_id, $user_id)
    {
        return DB::table(self::TABLE_NAME)
            ->where('article_id', $article_id)
            ->where('user_id', $user_id)
            ->exists();
    }
}

