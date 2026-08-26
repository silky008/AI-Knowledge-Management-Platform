<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    protected $fillable = [
        'user_id',
        'title',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'status',
        'processing_started_at',
    ];

    protected $casts = [
        'processing_started_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
