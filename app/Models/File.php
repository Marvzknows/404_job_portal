<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class File extends Model
{
    protected $fillable = [
        'uploaded_by',
        'file_name',
        'file_path',
        'file_size',
        'url',
    ];

    function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
