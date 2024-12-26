<div class="card card--layout">
    <div class="card__header">
        <h4 class="card__title">User Stats</h4>
    </div>
    <div class="flex flex--col--1">



        
        @foreach ($activities as $activity)
            
            <div class="flex__box flex__box--secondary">
                <span class="text--lg">{{ $activity['name'] }}</span>
                <span class="text--sm">{{ $activity['count'] }}</span>
            </div>



        @endforeach



    </div>





    
        


</div>
