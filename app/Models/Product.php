<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'name',
        'category_id',
        'sku',
        'cost_price',
        'selling_price',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function registerMediaCollection(): void
    {
        $this->addMediaCollection('images')
             ->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(300)
            ->height(300);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}