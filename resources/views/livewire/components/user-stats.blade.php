<div class="card card--layout">
    <div class="card__header">
        <h4 class="card__title">User Stats</h4>
    </div>
    <div class="flex flex--col--1">

        @if ($suggested_activities)
        <div class="flex__box flex__box--tags">
            <h4 class="card__title card__title--secondary">Suggested Activities</h4>
           

                @foreach ($suggested_activities as $activity)
                <span class="tag">
                    {{ $activity['name'] }}
                </span>
                @endforeach

            
        </div>
        @endif


        <div class="flex__box flex__box--primary">
            <span class="text--lg">Coin multiplier</span>
            <span class="text--sm">x{{ $coin_multiplier }}</span>
        </div>

        <div class="flex__box flex__box--primary">
            <span class="text--lg">Energy multiplier</span>
            <span class="text--sm">x{{ $energy_multiplier }}</span>
        </div> 

    </div>


</div>
