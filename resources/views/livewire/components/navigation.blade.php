@if (auth()->user())


<div>

<nav class="navigation">

     <div class="hamburger" x-data="{ isOpen: false }">
        <div class="hamburger__icon" @click="isOpen = true">
            <span class="hamburger__icon__line"></span>
            <span class="hamburger__icon__line"></span>
            <span class="hamburger__icon__line"></span>
        </div>

      
        <div 
            class="panel" 
            :class="{ 'panel--active': isOpen }"
            x-show="isOpen"
            @click.away="isOpen = false"
            x-transition.opacity.duration.300ms
        >
            
            <button class="panel__close" @click="isOpen = false">
                <img src="/images/close.svg" alt="close" class="panel__close__icon">
            </button>

           
            <ul class="panel__list">
                <h3 class="panel__heading">
                    Hi, {{ $username }}
                </h3>
                <li class="panel__item">
                    <a href="{{ route('user.dashboard') }}" class="panel__link">
                        Activity
                    </a>
                </li>
                <li class="panel__item">
                    <a href="{{ route('user.profile') }}" class="panel__link">
                        Profile
                    </a>
                </li>
               <li class="panel__item">
                    <a href="{{ route('user.rewards') }}" class="panel__link">
                        Rewards
                    </a>
                </li>

                <li class="panel__item">
                    <a href="{{ route('user.faq') }}" class="panel__link">
                        About
                    </a>
                </li>
                <li class="panel__item">
                    <a href="{{ route('user.coins') }}" class="panel__link">
                        Rest Bucks
                    </a>
                </li>
                <li class="panel__item">
                    <a href="{{ route('user.events') }}" class="panel__link">
                        Events
                    </a>
                </li>
                <li class="panel__item">
                    <a href="{{ route('user.roadmap') }}" class="panel__link">
                        Roadmap
                    </a>
                </li>
                
               
                
                <li class="panel__item">
                    <a href="{{ route('user.achievements') }}" class="panel__link">
                        Achievements
                    </a>
                </li>

                <li class="panel__item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="panel__button">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
            <div class="panel__logo">
                <h3 class="panel__logo__heading">
                    RestApp
                </h3>
            </div>
        </div>
    
    
</div>
<ul class="navigation__list navigation__list--phone">
    
    <li>
        <a href="#" class="navigation__link navigation__link--primary navigation__link--rest">
            <img src="/images/rest.svg" alt="rest" class="navigation__icon navigation__icon--link">
            <span class="navigation__link__text">{{auth()->user()->rest_bucks}} $REST</span>
        </a>
    </li>
    <li>
        <a href="#" class="navigation__link navigation__link--primary navigation__link--energy">
            <img src="/images/energy.svg" alt="energy" class="navigation__icon navigation__icon--link">
            <span class="navigation__link__text">{{auth()->user()->energy}} / 96</span>
        </a>
    </li>
      
</ul>


     <ul class="navigation__list navigation__list--left">
            <li class="navigation__item">
            
                <div x-data="{ dropdownOpen: false }" class="dropdown">
        <a href="#" class="navigation__link navigation__link--secondary" @click.prevent="dropdownOpen = !dropdownOpen">
            <img src="/images/user.svg" alt="profile" class="navigation__icon">
        </a>

        <ul x-show="dropdownOpen" @click.outside="dropdownOpen = false" class="dropdown__list">
            <li><a href="{{ route('user.profile')}}"  class="dropdown__link">Profile</a></li>
            <li><a href="{{ route('user.rewards') }}" class="dropdown__link">Rewards</a></li>
            <li><a href="{{ route('user.faq') }}" class="dropdown__link">About</a></li>
            <li><a href="{{ route('user.coins')}}" class="dropdown__link">Rest bucks</a></li>
            <li><a href="{{ route('user.events') }}" class="dropdown__link">Events</a></li>
            <li><a href="{{ route('user.roadmap') }}" class="dropdown__link">Roadmap</a></li>
            <li><a href="{{ route('user.achievements')}}"  class="dropdown__link">Achievements</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown__button">Logout</button>
                </form>
            </li>
        </ul>
            
            <li><span class="navigation__text">Hi, {{$username}}</span></li>
        </ul>
       


    <ul class="navigation__list navigation__list--right">
    
        <li>
            
            <a href="{{ route('user.dashboard') }}" class="navigation__link navigation__link--secondary">
            <span class="navigation__link__text">Activity</span>
            </a>
        </li>

      

         <li>
            <a href="#" class="navigation__link navigation__link--primary navigation__link--rest">
             <img src="/images/rest.svg" alt="rest" class="navigation__icon navigation__icon--link">
            <span class="navigation__link__text">{{auth()->user()->rest_bucks}} $REST</span>
            </a>
        </li>

       <li>
            
            <a href="#" class="navigation__link navigation__link--primary navigation__link--energy">
            <img src="/images/energy.svg" alt="energy" class="navigation__icon navigation__icon--link">
            <span class="navigation__link__text">{{auth()->user()->energy}} / 96</span>
            </a>
        </li> 

        <li wire:poll.60s="getNotifications">
            
            <div x-data="{ dropdownOpen: false }" class="dropdown">
                <a href="#" class="navigation__link navigation__link--primary navigation__link--help" @click.prevent="dropdownOpen = !dropdownOpen">
                    <img src="/images/notifications.svg" alt="notifications" class="navigation__icon navigation__icon--link">
                </a>

                <!-- Dropdown content -->
             <ul x-show="dropdownOpen" @click.outside="dropdownOpen = false" class="dropdown__list dropdown__list--notifications">
                @if ($notifications->isEmpty())
                    <li class="dropdown__item dropdown__item--notifications">
                        <span class="dropdown__link dropdown__link--centered">
                            There are no new notifications!
                        </span>
                    </li>
                @else
                    @foreach ($notifications->take(15) as $notification)
                        <li class="dropdown__item dropdown__item--notifications">
                            <div class="dropdown__content">
                                <a href="#" class="dropdown__link dropdown__link--notification">
                                    {{ $notification->title }}
                                </a>
                                <p class="dropdown__text">{{ $notification->message }}</p>
                                <small class="dropdown__small">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </li>
                    @endforeach
                    @if ($notifications->count() > 10)
                        <li class="dropdown__item dropdown__item--notifications">
                            <a href="{{ route('user.notifications') }}" class="dropdown__link dropdown__link--centered">
                                See All Notifications
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
            </div>
        </li>

        
        
     

        
    </ul>
</nav>

</div>

@endif
