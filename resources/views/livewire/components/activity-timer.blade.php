<div class="card card--layout">
    @if ($activity)
        <div class="card__box">
            <div class="slider">
                <div class="slider__items">
                    <div class="slider__dialog">
                        <span class="slider__dialog__text">{{ $activity->type == 'add' ? '+' : '-' }}</span>
                        <img src="/images/energy.svg" alt="energy" class="slider__dialog__energy">
                        <span class="slider__dialog__text">{{ $activity->energy_change }}</span>
                    </div>
                    <div class="slider__item slider__item--active">
                        <img class="image image--listed image--listed--{{ strtolower(str_replace(' ', '_', $activity->name)) }}" 
                             src="{{ asset('images/activities/' . strtolower(str_replace(' ', '_', $activity->name)) . '.svg') }}" 
                             alt="{{ $activity->name }}">
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="activity-timer__no-activity">
            <p>No active activity found.</p>
        </div>
    @endif

    <div class="flex flex--card">
        <div class="card__box card__box--stats">
            <h3 class="card__title">{{ $activity->name }}</h3>
            <p class="card__text">{{ $activity->description }}</p>
            <p class="card__text" wire:poll.60s="tick">Remaining: (min) {{ $remaining_time }} / {{ $activity->duration }}</p>
        </div>
    </div>

    <!-- Progress bar showing the remaining time -->
    <div class="progress">
        <div class="progress__bar" style="width: {{ $progress }}%">
        </div>
    </div>
</div>