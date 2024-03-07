<?php

namespace App\Models;

use App\Components\Eloquent\Concerns\HasPasswordAutoHash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use SoftDeletes, HasFactory, HasPasswordAutoHash, HasRoles;

    protected $table = "admins";

    protected $fillable = ['name', 'email', 'phone', 'level', 'password'];
}
