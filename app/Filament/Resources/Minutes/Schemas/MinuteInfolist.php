<?php

namespace App\Filament\Resources\Minutes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MinuteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('title')
                    ->placeholder('-'),
                TextEntry::make('venue')
                    ->placeholder('-'),
                TextEntry::make('date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('time')
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('participants')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('attendees')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('absentees')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('meeting.title')
                    ->label('Meeting'),
                TextEntry::make('content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('recorded_by')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('approved_by')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
