<?php

namespace App\Filament\Resources\Sms\Pages;

use App\Filament\Resources\Sms\SmsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSms extends EditRecord
{
    protected static string $resource = SmsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
