<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required(),
                TextInput::make('application_num')
                    ->required(),
                TextInput::make('session_num')
                    ->required(),
                TextInput::make('dev_permit_num'),
                TextInput::make('permit_num'),
                TextInput::make('title')
                    ->required(),
                TextInput::make('firstname')
                    ->required(),
                TextInput::make('lastname')
                    ->required(),
                TextInput::make('contact')
                    ->required(),
                Select::make('locality_id')
                    ->relationship('locality', 'name')
                    ->required(),
                Select::make('sector_id')
                    ->relationship('sector', 'name')
                    ->required(),
                TextInput::make('monthly_session_id')
                    ->required(),
                TextInput::make('block')
                    ->required(),
                TextInput::make('plot_number')
                    ->required(),
                TextInput::make('shelf')
                    ->numeric(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('address'),
                TextInput::make('house_no')
                    ->required(),
                TextInput::make('height')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('scanned_app_documents')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('processed')
                    ->required(),
                Toggle::make('existing')
                    ->required(),
                Textarea::make('use')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('approved_on'),
            ]);
    }
}
