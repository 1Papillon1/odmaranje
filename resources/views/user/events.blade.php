<x-app-layout>
    <div class="card card--layout">

        <div class="flex flex--col--1">
         
            @foreach($events as $event)
            <div class="flex__box flex__box--event">
                <h3 class="card__title">{{$event->name}}</h3>
                <h4 class="card__subtitle">{{$event->description}}</h4>
                
                <h4 class="card__subtitle">{{date('Y-m-d', strtotime($event->start_time))}} To {{date('Y-m-d', strtotime($event->end_time))}}</h4>
                <h4 class="card__subtitle">{{$event->reward}} $REST</h4>
            </div>
            @endforeach

        </div>

        </div>
</x-app-layout> 