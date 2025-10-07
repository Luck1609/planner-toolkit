<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\InteractsWithMedia;

class Office extends Model
{
  use HasUuids, InteractsWithMedia;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = [
    'name',
    'email',
    'initials',
    'address',
    'shelves',
    'region_id',
    'district_id'
  ];

  public function region() {
    return $this->belongsTo(Region::class);
  }

  public function district() {
    return $this->belongsTo(District::class);
  }

  public function contacts(): MorphOne
  {
    return $this->morphOne(Contact::class, 'contact');
  }
}
