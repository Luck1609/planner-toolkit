<?php

namespace App\Filament\Resources\Extracts\Pages;

use App\Filament\Resources\Extracts\ExtractResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExtract extends ViewRecord
{
    protected static string $resource = ExtractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
