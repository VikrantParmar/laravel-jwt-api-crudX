<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Blog extends Model
{
    use HasFactory;
    const DEFAULT_IMAGE = '100_no_img.jpg';
    protected $fillable = ['title', 'content', 'category_id', 'slug', 'image','user_id'];

    protected $appends = ['blog_image_url','formatted_created_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getBlogImageUrlAttribute()
    {
        $default = \Storage::disk('default')->url(self::DEFAULT_IMAGE);
        $profileImage = filter_var($this->image, FILTER_VALIDATE_URL)
            ? $this->image
            : ($this->image ? \Storage::disk('blog')->url($this->image) : $default);
        return (object)[
            'original' => $profileImage,
            'default' => $default
        ];
    }
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }
}