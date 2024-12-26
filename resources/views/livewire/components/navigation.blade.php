@if (auth()->user())

{{-- dodaj glavni div u livewire3 inače ne radi --}}
<div>

<nav class="navigation">

     <div class="hamburger" x-data="{ isOpen: false }">
        <div class="hamburger__icon" @click="isOpen = true">
            <span class="hamburger__icon__line"></span>
            <span class="hamburger__icon__line"></span>
            <span class="hamburger__icon__line"></span>
        </div>

        <!-- Panel -->
        <div 
            class="panel" 
            :class="{ 'panel--active': isOpen }"
            x-show="isOpen"
            @click.away="isOpen = false"
            x-transition.opacity.duration.300ms
        >
            <!-- Close Button -->
            <button class="panel__close" @click="isOpen = false">
                <img src="/images/close.svg" alt="close" class="panel__close__icon">
            </button>

            <!-- Panel Content -->
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
                    <a href="{{ route('user.stats') }}" class="panel__link">
                        Stats
                    </a>
                </li>
                <li class="panel__item">
                    <a href="{{ route('user.coins') }}" class="panel__link">
                        Rest bucks
                    </a>
                </li>
                <li class="panel__item">
                    <a href="{{ route('user.achievements') }}" class="panel__link">
                        Achievements
                    </a>
                </li>
                <li class="panel__item">
                    <a href="{{ route('user.profile') }}" class="panel__link">
                        Update profile
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
      <li>
            
            <a href="/user/faq" class="navigation__link navigation__link--primary navigation__link--help">
            <img src="/images/help.svg" alt="energy" class="navigation__icon navigation__icon--link">
            
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
         <li><a href="{{ route('user.stats')}}" class="dropdown__link">Stats</a></li>
            <li><a href="{{ route('user.coins')}}" class="dropdown__link">Rest bucks</a></li>
            <li><a href="{{ route('user.achievements')}}"  class="dropdown__link">Achievements</a></li>
            <li><a href="{{ route('user.profile')}}"  class="dropdown__link">Update profile</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown__button">Logout</button>
                </form>
            </li>
        </ul>
            
            <li><span class="navigation__text">Hi, {{$username}}</span></li>
        </ul>
        {{--hamburger--}}


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

        <li>
            
            <a href="/user/faq" class="navigation__link navigation__link--primary navigation__link--help">
            <img src="/images/help.svg" alt="energy" class="navigation__icon navigation__icon--link">
            
            </a>
        </li>
        
     

        
    </ul>
</nav>

</div>

@endif
