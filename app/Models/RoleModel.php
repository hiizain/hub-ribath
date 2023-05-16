<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class RoleModel extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    protected $guard_name = 'web';

    // protected $table = 'roles';

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $fillable = [
    //     'name',
    //     'guard_name',
    //     'description',
    // ];

    // Baru
    public function user()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    
}
