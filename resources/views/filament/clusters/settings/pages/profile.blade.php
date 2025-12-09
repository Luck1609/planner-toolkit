<x-filament-panels::page>
  <form wire:submit="saveBasicForm" class="">
    <div class="bg-white dark:bg-[#09090B] rounded-lg mb-10">
      {{ $this->basicForm }}

      <div class="flex justify-end px-5 pb-5 mt-5">
        <x-filament::button type="submit" class="w-2/6 py-3">Update Information</x-filament::button>
      </div>
    </div>
  <form>

  <form wire:submit="saveSecurityForm">

    <div class="bg-white dark:bg-[#09090B] rounded-lg">
      {{ $this->securityForm }}

      <div class="flex justify-end px-5 pb-5 mt-5">
        <x-filament::button type="submit" class="w-2/6 py-3">Update password</x-filament::button>
      </div>
    </div>
  <form>
</x-filament-panels::page>
