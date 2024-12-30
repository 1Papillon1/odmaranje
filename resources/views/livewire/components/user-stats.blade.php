<div class="card card--layout">
    <div class="card__header">
        <h4 class="card__title">User Stats</h4>
    </div>
    <div class="flex flex--col--1">

        @if ($suggested_activities)
        <div class="flex__box flex__box--secondary">
            <span class="text--lg">Suggested activities</span>
            <span class="text--sm">

                @foreach ($suggested_activities as $activity)
                    {{ $activity['name'] }}<br>
                @endforeach

            </span>
        </div>
        @endif

        
        @foreach ($activities as $activity)
            
            <div class="flex__box flex__box--secondary">
                <span class="text--lg">{{ $activity['name'] }}</span>
                <span class="text--sm">{{ $activity['count'] }}</span>
            </div>



        @endforeach

        <div class="flex__box flex__box--secondary">
            <span class="text--lg">Coin multiplier</span>
            <span class="text--sm">x{{ $coin_multiplier }}</span>
        </div>

        <div class="flex__box flex__box--secondary">
            <span class="text--lg">Energy multiplier</span>
            <span class="text--sm">x{{ $energy_multiplier }}</span>
        </div>


    </div>





    
        


</div>
