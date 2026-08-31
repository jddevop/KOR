<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Annual_leave extends Model
{
    use HasFactory;
    
    protected $table = 'annual_leave';
    
    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }
}
