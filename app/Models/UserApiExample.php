<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserApiExample extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_api_example';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['external_id', 'name', 'email', 'phone', 'raw_data'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'external_id');
    }
}
