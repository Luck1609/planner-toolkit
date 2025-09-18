<?php

namespace App\Filament\Resources\Sms;

use App\Filament\Resources\Sms\Pages\CreateSms;
use App\Filament\Resources\Sms\Pages\EditSms;
use App\Filament\Resources\Sms\Pages\ListSms;
use App\Filament\Resources\Sms\Schemas\SmsForm;
use App\Filament\Resources\Sms\Tables\SmsTable;
use App\Models\Sms;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SmsResource extends Resource
{
    protected static ?string $model = Sms::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDevicePhoneMobile;

    public static function form(Schema $schema): Schema
    {
        return SmsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SmsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSms::route('/'),
            'create' => CreateSms::route('/create'),
            'edit' => EditSms::route('/{record}/edit'),
        ];
    }
}
