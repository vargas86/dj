<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Role;

class Admin extends User
{
    //
    protected $table = 'users';

    protected $attributes = array(
        'role_id' => 2,
    );

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('author', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $role = Role::where('name', '=', 'administrator')->first();
            if($role) {
                $builder->where('role_id', '=', $role->id);
            } else {
                // abort(500);
            }
        });
    }
    
}
