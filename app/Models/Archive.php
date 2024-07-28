<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Archive extends Model
{
    use HasFactory;
    protected $table = 'archives';
    protected $fillable = [
        'id',
        'title',
        'description',
        'file',
        'category_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($archive) {
            $archive->created_at = Carbon::now('Asia/Jakarta');
            $archive->updated_at = Carbon::now('Asia/Jakarta');
        });

        static::updating(function ($archive) {
            $archive->updated_at = Carbon::now('Asia/Jakarta');
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
