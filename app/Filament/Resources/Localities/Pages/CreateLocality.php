<?php

namespace App\Filament\Resources\Localities\Pages;

use App\Filament\Resources\Localities\LocalityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLocality extends CreateRecord
{
    protected static string $resource = LocalityResource::class;


  protected function mutateFormDataBeforeCreate(array $data): array
  {
    logger('Locality data', $data);

    return $data;
  }
}
