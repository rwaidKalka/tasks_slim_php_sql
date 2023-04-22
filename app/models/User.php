<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model ;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['username', 'email', 'password'];


    protected $hidden = ['password'];

    public $timestamps = false;

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

}