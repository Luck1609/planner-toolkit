<x-filament-panels::page class="divide-y">
  <div class="">
    <h2 class="text-2xl font-bold mb-5">Permit Application SMS Notification</h2>

    <div class="space-y-3">
      <x-filament::tabs label="">
      </x-filament::tabs>
      <div>
        {{ $this->received }}
      </div>

      <div>
        {{ $this->recommended }}
      </div>

      <div>
        {{ $this->approved }}
      </div>

      <div>
        {{ $this->deferred }}
      </div>

      <div>
        {{ $this->refused }}
      </div>
    </div>
  </div>

  <div class="">
    <h2 class="text-2xl font-bold mb-5">Meeting SMS Notification</h2>

    <div>
      {{ $this->meeting }}
    </div>
  </div>
</x-filament-panels::page>
