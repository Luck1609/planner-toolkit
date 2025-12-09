<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Profile extends Page
{
  protected string $view = 'filament.clusters.settings.pages.profile';

  protected static ?int $navigationSort = 1;

  protected static ?string $cluster = SettingsCluster::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

  public array $basicFormValues = [];
  public array $securityFormValues = [];

  public function getForms(): array
  {
    return [
      'basicForm',
      'securityForm',
    ];
  }

  public function mount()
  {
    $user = Auth::user();
    $this->basicFormValues = [
      'firstname' => $user->firstname,
      'lastname' => $user->lastname,
      'email' => $user->email,
      'phone' => $user->phone,
    ];
  }

  public function basicForm(Schema $schema): Schema
  {
    return $schema
      ->schema([
        Section::make('Basic info')
          ->description('Update your personal information')
          ->icon('heroicon-o-user')
          ->schema([
            TextInput::make('firstname')
              ->placeholder('Type in your firstname')
              ->statePath('basicFormValues.firstname'),

            TextInput::make('lastname')
              ->placeholder('Type in your lastname')
              ->statePath('basicFormValues.lastname'),

            TextInput::make('email')
              ->placeholder('Type in your email address')
              ->statePath('basicFormValues.email'),

            TextInput::make('phone')
              ->placeholder('Type in your phone number')
              ->statePath('basicFormValues.phone'),
          ])
          ->columns(2),
      ]);
  }

  public function securityForm(Schema $schema): Schema
  {
    return $schema
      ->schema([
        Section::make('Account security')
          ->description('Update your personal information')
          ->icon('heroicon-o-lock-closed')
          ->schema([
            TextInput::make('old_password')
              ->label('Current password')
              ->placeholder('************************'),

            TextInput::make('password')
              ->label('New password')
              ->placeholder('************************'),

            TextInput::make('password_confirmation')
              ->label('Confirm password')
              ->placeholder('************************'),
          ])
          ->columns(2),
      ]);
  }

  public function saveBasicForm(): void {}

  public function saveSecurityForm(): void {}
}
