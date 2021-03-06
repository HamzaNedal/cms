<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable, SearchableTrait;
    protected $fillable = ['title', 'description', 'category_id', 'comment_able', 'status', 'slug', 'post_type', 'user_id'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'posts.title' => 10,
            'posts.description' => 10,
        ]
    ];
    public function scopePost($query)
    {
        return $query->where('post_type', 'post');
    }
    public function scopeDescById($query)
    {
        return $query->orderBy('id', 'desc');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function approved_comments()
    {
        return $this->hasMany(Comment::class)->whereStatus(1);
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class, 'post_id');
    }

    public function status()
    {
        return $this->status == 1 ?  __('Active') : __('Inactive');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'posts_tags');
    }
}
