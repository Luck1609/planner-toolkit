<?php

namespace App\Filament\Resources\Meetings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class MeetingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('monthly_session_id'),
                TextInput::make('title')
                    ->required(),
                Textarea::make('agenda')
                    ->columnSpanFull(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('time')
                    ->required(),
                TextInput::make('venue')
                    ->required(),
                TextInput::make('type')
                    ->required(),
                Textarea::make('participants')
                    ->columnSpanFull(),
            ]);
    }
}
