<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logapproved extends Model
{
    use HasFactory;

    protected $table = 'log_approveds';
    protected $guarded = [];
}
