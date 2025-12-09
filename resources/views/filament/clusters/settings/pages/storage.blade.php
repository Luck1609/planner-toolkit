@php
use Filament\Support\Icons\Heroicon;
@endphp

<x-filament-panels::page>
  <ul class="w-full space-y-5">
    <li class="flex items-center justify-between p-5 rounded-lg dark:bg-[#18181B]">
      <div class="flex items-center space-x-2">
        <div class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-export">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
            <path d="M4 6v6c0 1.657 3.582 3 8 3c1.118 0 2.183 -.086 3.15 -.241" />
            <path d="M20 12v-6" />
            <path d="M4 12v6c0 1.657 3.582 3 8 3c.157 0 .312 -.002 .466 -.005" />
            <path d="M16 19h6" />
            <path d="M19 16l3 3l-3 3" />
          </svg>
        </div>

        <div class="">
          <p>Create restore point</p>
          <small class="dark:text-slate-400">Last backup date: 16 Sept. 2025</small>
        </div>
      </div>

      <x-filament::button
        wire:click="openNewUserModal"
        icon="icon-database-export">
        Create backup
      </x-filament::button>
    </li>

    <li class="flex items-center justify-between p-5 rounded-lg dark:bg-[#18181B]">
      <div class="flex items-center space-x-2">
        <div class="h-10 w-10 rounded-lg bg-white/10 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-database-import">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
            <path d="M4 6v6c0 1.657 3.582 3 8 3c.856 0 1.68 -.05 2.454 -.144m5.546 -2.856v-6" />
            <path d="M4 12v6c0 1.657 3.582 3 8 3c.171 0 .341 -.002 .51 -.006" />
            <path d="M19 22v-6" />
            <path d="M22 19l-3 -3l-3 3" />
          </svg>
        </div>

        <p>Restore from backup</p>
      </div>

      <x-filament::button
        wire:click="openNewUserModal"
        icon="icon-database-import">
        Import backup
      </x-filament::button>
    </li>

    <li class="flex items-center justify-between p-5 rounded-lg dark:bg-[#18181B]">
      <div class="flex items-center space-x-2">
        <div class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
            <path d="M7 11l5 5l5 -5" />
            <path d="M12 4l0 12" />
          </svg>
        </div>

        <div class="">
          <p>Backup saving location</p>
          <small class="dark:text-slate-400">Location/path</small>
        </div>
      </div>

      <div class="flex space-x-2">
        <x-filament::button
          wire:click="openNewUserModal"
          icon="heroicon-o-arrow-down-tray"
          color="warning">
          Open file location
        </x-filament::button>
        <x-filament::button
          wire:click="openNewUserModal"
          icon="heroicon-o-arrow-down-tray">
          Change path
        </x-filament::button>
      </div>
    </li>
  </ul>
</x-filament-panels::page>
