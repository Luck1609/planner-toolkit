<?php

namespace App\Filament\Resources\Minutes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class MinuteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title'),
                TextInput::make('venue'),
                DatePicker::make('date'),
                TimePicker::make('time'),
                Textarea::make('participants')
                    ->columnSpanFull(),
                Textarea::make('attendees')
                    ->columnSpanFull(),
                Textarea::make('absentees')
                    ->columnSpanFull(),
                Select::make('meeting_id')
                    ->relationship('meeting', 'title')
                    ->required(),
                Textarea::make('content')
                    ->columnSpanFull(),
                Textarea::make('recorded_by')
                    ->columnSpanFull(),
                Textarea::make('approved_by')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
            ]);
    }
}
