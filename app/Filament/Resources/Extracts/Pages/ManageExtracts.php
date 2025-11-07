<?php

namespace App\Filament\Resources\Extracts\Pages;

use App\Filament\Resources\Extracts\ExtractResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageExtracts extends ManageRecords
{
    protected static string $resource = ExtractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
