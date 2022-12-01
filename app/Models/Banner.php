<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    //------------ Relations
    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    //----------- Attridutes
    public function getThumbnailPathAttribute()
    {
        return $this->thumbnail ? Storage::url($this->thumbnail->src) :
            Storage::url('images/dummy/dummy-placeholder.png');
    }

    //----------- Scope
    public function scopeIsActive(Builder $builder, bool $activity = true)
    {
        return $builder->where('is_active', $activity);
    }
}
