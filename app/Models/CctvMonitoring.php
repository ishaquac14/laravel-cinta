<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CctvMonitoring extends Model
{
    use HasFactory;

    protected $table = 'cctv_monitorings';
    protected $guarded = ['id'];

    public function cctv()
    {
        return $this->belongsTo(Cctv::class, 'cctv_id');
    }
}
