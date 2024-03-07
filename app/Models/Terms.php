<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Components\Eloquent\Model;

class Terms extends Model
{
    use HasFactory;

    protected $table = "terms";

    protected $fillable = ['name', 'content'];

}
