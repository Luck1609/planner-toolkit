<?php

namespace App\Filament\Resources\Extracts\Schemas;

use App\Models\Extract;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExtractInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('title'),
                TextEntry::make('firstname'),
                TextEntry::make('lastname'),
                TextEntry::make('locality.name')
                    ->label('Locality'),
                TextEntry::make('sector.name')
                    ->label('Sector'),
                TextEntry::make('block'),
                TextEntry::make('plot_number'),
                TextEntry::make('allocation_date'),
                TextEntry::make('registration_date'),
                TextEntry::make('phone_number'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Extract $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
