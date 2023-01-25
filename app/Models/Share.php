<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_id',
        'file_address',
        'file_name',
        'file_size',
        'owner',
        'user_id',
        'user_address',
        'user_name'
    ];

    public function file() 
    {
        return $this->belongsTo(File::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
