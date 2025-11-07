<?php

namespace App\Filament\Resources\Minutes\Pages;

use App\Filament\Resources\Minutes\MinuteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMinute extends CreateRecord
{
    protected static string $resource = MinuteResource::class;

  public function mount(): void
  {
    parent::mount();

    $this->form->fill([
      'content' => [
        ['title' => 'OPENING', 'contents' => '', 'label' => 'Opening'],
        ['title' => 'READING AND ADOPTION OF PREVIOUS MINUTES', 'contents' => '', 'label' => 'Reading and adoption of previous minutes'],
        ['title' => 'MATTERS ARISING', 'contents' => '', 'label' => 'Matters arising'],
        ['title' => 'NEW BUSINESS', 'contents' => '', 'label' => 'Agenda'],
        ['title' => 'ANY OTHER BUSINESS', 'contents' => '', 'label' => 'Other matters'],
        ['title' => 'CLOSURE', 'contents' => '', 'label' => 'Closure']
      ],
      'participants' => [
        ['name' => '', 'designation' => '', 'role' => '']
      ],
      'absentees' => [
        ['name' => '', 'designation' => '', 'role' => '']
      ],
      'attendees' => [
        ['name' => '', 'designation' => '']
      ],
      'recorded_by' => [[
        'name' => '',
        'role' => '',
        'designation' => ''
      ]],
      'approved_by' => [[
        'name' => '',
        'role' => '',
        'designation' => ''
      ]],
    ]);
  }
}
