<?php

namespace App\Filament\Resources\Letters\Schemas;

use App\Models\Letter;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LetterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('reference')
                    ->placeholder('-'),
                TextEntry::make('organisation')
                    ->placeholder('-'),
                TextEntry::make('date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('content')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('state')
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Letter $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
