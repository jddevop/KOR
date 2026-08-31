<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Notification extends Model
{
    use HasFactory;
    
    protected $table = 'notification';
    
    public function user()
    {
      return $this->belongsTo(User::class,'from_id');
    }
}
