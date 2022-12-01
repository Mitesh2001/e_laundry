<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    //------------ Relations
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Media::class);
    }

    //------------ Attributes
    public function getThumbnailPathAttribute()
    {
        return $this->thumbnail ? Storage::url($this->thumbnail->src) :
            Storage::url('images/dummy/dummy-placeholder.png');
    }

    //----------- Scopes
    public function scopeIsActive(Builder $builder, bool $activity = true)
    {
        return $builder->where('is_active', $activity);
    }
}
