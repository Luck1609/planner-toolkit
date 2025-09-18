<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->searchable(),
                TextColumn::make('application_num')
                    ->searchable(),
                TextColumn::make('session_num')
                    ->searchable(),
                TextColumn::make('dev_permit_num')
                    ->searchable(),
                TextColumn::make('permit_num')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('firstname')
                    ->searchable(),
                TextColumn::make('lastname')
                    ->searchable(),
                TextColumn::make('contact')
                    ->searchable(),
                TextColumn::make('locality.name')
                    ->searchable(),
                TextColumn::make('sector.name')
                    ->searchable(),
                TextColumn::make('monthly_session_id')
                    ->searchable(),
                TextColumn::make('block')
                    ->searchable(),
                TextColumn::make('plot_number')
                    ->searchable(),
                TextColumn::make('shelf')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('house_no')
                    ->searchable(),
                TextColumn::make('height')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('processed')
                    ->boolean(),
                IconColumn::make('existing')
                    ->boolean(),
                TextColumn::make('approved_on')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
