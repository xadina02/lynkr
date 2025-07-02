<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    
    const JSON_API_TYPE = 'countries';

    protected $fillable = [
        'code',
        'name'
    ];

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'country_brands', 'country_code', 'brand_id');
    }
}
