<?php

namespace App\Filament\Resources\Committees\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CommitteesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')->label('Full name')
          ->default(fn(Model $member) => "{$member->title} {$member->firstname} {$member->lastname}"),
        TextColumn::make('contact')->label('Phone number'),
        TextColumn::make('email')->label('Email'),
        TextColumn::make('panel')
          ->badge()
          ->color(fn(string $state) => match ($state) {
            'TSC' => 'info',
            'SPC' => 'primary',
          }),
        TextColumn::make('status')
          ->default(fn(Model $member) => !$member->status === '0' ? 'Inactive' : 'Active')
          ->badge()
          ->color(fn(string $state) => match ($state) {
            '0' => 'danger',
            '1' => 'success',
          }),
        TextColumn::make('role')->label('Role'),
        TextColumn::make('designation')->label('Designation'),
      ])
      ->filters([
        SelectFilter::make('panel')
          ->options([
            '' => 'All',
            'TSC' => 'TSC',
            'SPC' => 'SPC'
          ])
      ])
      ->searchable([
        
      ])
      ->recordActions([
        ActionGroup::make([
          Action::make('view')
            ->icon(Heroicon::OutlinedEye),
          Action::make('edit')
            ->icon(Heroicon::OutlinedPencil),
          Action::make('delete')
            ->icon(Heroicon::OutlinedTrash),
        ])
        // ViewAction::make(),
        // EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
