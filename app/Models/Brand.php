<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Brand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'brands';
    
    const JSON_API_TYPE = 'brands';

    protected $fillable = [
        'name',
        'rating'
    ];

    public const PATH = 'brand_image';

    protected $appends = ['image'];

    public static $rules = [
        'name' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'image' => 'image|mimes:jpg,jpeg,png',
    ];
    

    public function getImageAttribute(): string
    {
        /** @var Media $media */
        $media = $this->getMedia(Brand::PATH)->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'country_brands', 'brand_id', 'country_code');
    }
}
