<?php

namespace App\Filament\Resources\Committees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommitteeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('firstname')
                    ->required(),
                TextInput::make('lastname')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('contact')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('designation')
                    ->required(),
                TextInput::make('panel')
                    ->required()
                    ->default('TSC'),
                TextInput::make('role')
                    ->required()
                    ->default('Member'),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
