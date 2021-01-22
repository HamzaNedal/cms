<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'url',
        'comment',
        'status',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeDescById($query)
    {
        return $query->orderBy('id','desc');
    }
    public function status()
    {
        return $this->status == 1 ?  __('Active') : __('Inactive');
    }
}
