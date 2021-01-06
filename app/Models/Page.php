<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory,SoftDeletes,Sluggable;
    protected $guarded = [];
    protected $table = 'posts';

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    function scopeIsPage($query)
    {
        $query->where('post_type', 'page');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class,'post_id');
    }

    
}
