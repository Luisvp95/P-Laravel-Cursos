<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','category_id','name', 'slug', 'image', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
		return $this->belongsTo(User::class);
	}

    public function posts()
    {
		return $this->hasMany(Post::class);
	}

    public function getExcerptAttribute()
    {
        return substr($this->description, 0, 80) ."...";
    }

    public function similar()
    {
        return $this->where('category_id', $this->category_id)
            //->whit('user')
            ->take(2)
            ->get();
    }
}