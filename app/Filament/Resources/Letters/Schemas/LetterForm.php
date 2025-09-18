<?php

namespace App\Filament\Resources\Letters\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LetterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference'),
                TextInput::make('organisation'),
                DatePicker::make('date'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                Textarea::make('content')
                    ->columnSpanFull(),
                TextInput::make('state'),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
            ]);
    }
}
