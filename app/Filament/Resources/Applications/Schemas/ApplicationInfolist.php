<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('user_id'),
                TextEntry::make('application_num'),
                TextEntry::make('session_num'),
                TextEntry::make('dev_permit_num')
                    ->placeholder('-'),
                TextEntry::make('permit_num')
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('firstname'),
                TextEntry::make('lastname'),
                TextEntry::make('contact'),
                TextEntry::make('locality.name')
                    ->label('Locality'),
                TextEntry::make('sector.name')
                    ->label('Sector'),
                TextEntry::make('monthly_session_id'),
                TextEntry::make('block'),
                TextEntry::make('plot_number'),
                TextEntry::make('shelf')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('type'),
                TextEntry::make('address')
                    ->placeholder('-'),
                TextEntry::make('house_no'),
                TextEntry::make('height')
                    ->numeric(),
                TextEntry::make('scanned_app_documents')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('processed')
                    ->boolean(),
                IconEntry::make('existing')
                    ->boolean(),
                TextEntry::make('use')
                    ->columnSpanFull(),
                TextEntry::make('approved_on')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
