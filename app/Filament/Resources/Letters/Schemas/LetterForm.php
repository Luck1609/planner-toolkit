<?php

namespace App\Filament\Resources\Letters\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class LetterForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
      TextInput::make('organisation')->placeholder('Organisation name')->required(),
      TextInput::make('reference')->placeholder('Reference')->required(),
      TextInput::make('contact')->placeholder('Sender\'s phone number')->required(),
      TextInput::make('email')->placeholder('Organisation\'s email address')->nullable()->email(),
      Group::make([
        DatePicker::make('date')->label('Date received')->required()->columnSpan(2),
        Radio::make('state')
          ->options([
            'outgoing' => 'Outgoing letter',
            'incoming' => 'incoming letter',
          ])
          ->label('State of letter'),
      ])
        ->live()
        ->columns(3),
      SpatieMediaLibraryFileUpload::make('copy')
        ->visible(fn (Get $get) => $get('incoming'))
        ->label('Upload copy of the letter'),
      RichEditor::make('content')
        ->visible(function (Get $get) {
          return $get('state') === 'outgoing';
        })
        ->columnSpanFull()
        ->toolbarButtons([
          // 'attachFiles',
          'blockquote',
          'bold',
          'bulletList',
          'codeBlock',
          'h2',
          'h3',
          'italic',
          'link',
          'orderedList',
          'redo',
          'strike',
          'underline',
          'undo',
        ])
      ]);
  }
}
