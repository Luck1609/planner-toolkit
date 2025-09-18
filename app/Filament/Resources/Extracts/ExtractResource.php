<?php

namespace App\Filament\Resources\Extracts;

use App\Filament\Resources\Extracts\Pages\CreateExtract;
use App\Filament\Resources\Extracts\Pages\EditExtract;
use App\Filament\Resources\Extracts\Pages\ListExtracts;
use App\Filament\Resources\Extracts\Pages\ViewExtract;
use App\Filament\Resources\Extracts\Schemas\ExtractForm;
use App\Filament\Resources\Extracts\Schemas\ExtractInfolist;
use App\Filament\Resources\Extracts\Tables\ExtractsTable;
use App\Models\Extract;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExtractResource extends Resource
{
    protected static ?string $model = Extract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    public static function form(Schema $schema): Schema
    {
        return ExtractForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExtractInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExtractsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExtracts::route('/'),
            'create' => CreateExtract::route('/create'),
            'view' => ViewExtract::route('/{record}'),
            'edit' => EditExtract::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
