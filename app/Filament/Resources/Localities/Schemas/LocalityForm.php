<?php

namespace App\Filament\Resources\Localities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LocalityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('initials')
                    ->required(),
            ]);
    }
}
