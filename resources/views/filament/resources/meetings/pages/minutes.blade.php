<x-filament-panels::page>
  @php
    print($this->getRecord());
  @endphp
    {{ $this->form }}
</x-filament-panels::page>
