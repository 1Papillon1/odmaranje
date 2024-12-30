<div class="card card--layout">
    
    <div class="card__box">
        <div class="slider">
            <!-- Rotating Activities -->


        
        @session('message')
        <div class="flex flex--card">
            <div x-data="{ isVisible: true }" x-show="isVisible" class="alert alert--message">
                {{ session('message') }}
                <button @click="isVisible = false" class="alert__close">
                    <img src="/images/close.svg" alt="close" class="alert__close__icon">
                </button>
            </div>
        </div>
        @endsession


            <div class="slider__items">
                <div class="slider__group">
                    <div class="slider__dialog">
                    
                        <span class="slider__dialog__text">{{ $activities[$currentIndex]->type == 'add' ? '+' : '-' }} </span>
                        <img src="/images/energy.svg" alt="energy" class="slider__dialog__energy">
                        @if ($activities[$currentIndex]->name == 'Sleep')
                                                    <span class="slider__dialog__text">{{ $activities[$currentIndex]->energy_change = 96 - $user->energy }}</span>

                        @else
                            <span class="slider__dialog__text">{{ $activities[$currentIndex]->energy_change }}</span>
                        @endif
                    </div>

                    @if ($restBucksChange)
                        <div class="slider__dialog">
                            
                            <span class="slider__dialog__text">+ {{ $restBucksChange }} $REST</span>
                        </div>
                    @endif
                </div>
              

             <button wire:click="rotateLeft" class="slider__nav__button slider__nav__button--left">
                    <img class="slider__icon slider__icon--left" src="/images/arrow.svg" alt="arrow">
            </button>

            
                @foreach($activities as $index => $activity)
                    @if ($activity->name == 'Sleep')
                 
                        <div class="slider__item {{ $currentIndex == $index ? 'slider__item--active' : '' }}"
                            style="--item-index: {{ $index - $currentIndex }};">
                            <p class="slider__logo">💤</p>
                        </div>
                    @else

                    <div class="slider__item {{ $currentIndex == $index ? 'slider__item--active' : '' }}"
                        style="--item-index: {{ $index - $currentIndex }};">
                        <img class="image image--listed image--listed--{{ strtolower(str_replace(' ', '_', $activity->name)) }}" src="{{ asset('images/activities/' . strtolower(str_replace(' ', '_', $activity->name)) . '.svg') }}" alt="{{ $activity->name }}">
                        

                     
                    </div>
                    @endif
                @endforeach

                 <button wire:click="rotateRight" class="slider__nav__button slider__nav__button--right">
                    
                                        <img class="slider__icon slider__icon--right" src="/images/arrow.svg" alt="arrow">

                      </button>
            </div>


        </div>
         
    </div>

<div class="flex flex--card">
    <div class="card__box card__box--stats">
        <h3 class="card__title">{{ $activities[$currentIndex]->name }}</h3>
        <p class="card__text">{{ $activities[$currentIndex]->description }}</p>
       
        <p class="card__text">Duration: {{ $activities[$currentIndex]->duration }} minutes</p>
        <button class="card__button" wire:click="startActivity">
            Start
        </button>
   </div>

   
</div>
    
    
</div>