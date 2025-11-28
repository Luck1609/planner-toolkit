@php
$color = $getMappedColor();
@endphp

<div class="flex items-center gap-2">
  <div
    class="w-4 h-4 rounded-full border-[{{$color}}]"
    style="background-color: {{ $color }}"></div>

  <span>{{ $getState() }}</span>
</div>
