<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    const DEFAULT_IMAGE = '100_no_img.jpg';
    protected $fillable = ['title', 'content', 'category_id', 'slug', 'image'];

    protected $appends = ['blog_image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getBlogImageUrlAttribute()
    {
        $default = \Storage::disk('default')->url(self::DEFAULT_IMAGE);
        $profileImage = $this->image ? \Storage::disk('blog')->url($this->image) : $default;
        return (object)[
            'original' => $profileImage,
            'default' => $default
        ];
    }
}