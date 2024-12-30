<div class="card card--layout">
    <div class="card__header">
        <h4 class="card__title">Notifications</h4>
    </div>
<div class="flex flex--col--1">
        @foreach ($notifications as $notification)
            <div class="flex__box flex__box--article">
                <span class="card__muted">{{ $notification->created_at->diffForHumans() }}</span>
                <h3 class="card__title card__title--secondary">{{ $notification->title }}</h3>
                <h4 class="card__subtitle card__subtitle--secondary">{{ $notification->message }}</h4>
            </div>
        @endforeach
    </div>

   
   {{$notifications->links()}} 
</div>