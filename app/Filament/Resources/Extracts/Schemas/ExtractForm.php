<?php

namespace App\Filament\Resources\Extracts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExtractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('firstname')
                    ->required(),
                TextInput::make('lastname')
                    ->required(),
                Select::make('locality_id')
                    ->relationship('locality', 'name')
                    ->required(),
                Select::make('sector_id')
                    ->relationship('sector', 'name')
                    ->required(),
                TextInput::make('block')
                    ->required(),
                TextInput::make('plot_number')
                    ->required(),
                TextInput::make('allocation_date')
                    ->required(),
                TextInput::make('registration_date')
                    ->required(),
                TextInput::make('phone_number')
                    ->tel()
                    ->required(),
            ]);
    }
}
