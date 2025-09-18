<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Letter extends Model implements HasMedia
{
  use HasUuids, InteractsWithMedia;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $guarded = [];

}
