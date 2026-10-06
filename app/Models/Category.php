<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'slug', 'description', 'status'];

    // Menentukan field sumber pembuat slug (default: name)
    protected string $slugSourceField = 'name';

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}