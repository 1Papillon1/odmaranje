<x-app-layout>
  @if ($activeActivityId)
  @livewire('components.activity-timer', ['activity_id' => $activeActivityId])
  @else
  @livewire('components.activity-start')
  @endif
   
</x-app-layout> 