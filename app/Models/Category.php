<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $guarded = [];

      public function sluggable() :array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeDescById($query)
    {
        return $query->orderBy('id','desc');
    }
}
