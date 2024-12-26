<div class="card card--layout">

<div class="flex flex--col--2">
    @foreach($achievements as $achievement)


    @if ($user->achievements->contains($achievement->id))
        <div class="flex__box flex__box--achievement">
            <img src="/images/tick.svg" alt="energy" class="flex__box__icon">

            <h3 class="card__title">{{$achievement->name}}</h3>
            <h4 class="card__subtitle">{{$achievement->description}}</h4>
        </div>
    @else 
        <div class="flex__box flex__box">
            
            <h3 class="card__title">{{$achievement->name}}</h3>
            <h4 class="card__subtitle">{{$achievement->description}}</h4>
        </div>
    @endif
    @endforeach
    

</div>

</div>