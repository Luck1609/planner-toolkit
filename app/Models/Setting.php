<?php

namespace App\Models;

use App\Casts\AsJSON;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends Model
{
  use HasUuids, InteractsWithMedia;

  protected function casts() {

    return [
      'value' => 'array'
    ];
  }

  protected $keyType = 'string';
  public $incrementing = false;

  protected $guarded = [];
}
