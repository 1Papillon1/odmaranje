<x-guest-layout>
    <!-- Landing Page -->
    <div class="flex flex--home">
    
        <!-- Title and Subtitle -->
        <div class="container container--home flex--column">
            <h1 class="container__title">Welcome to RestApp</h1>
             <h4 class="logo logo--title">RestApp</h4>

            <h2 class="container__subtitle">"<i>Wisdom is knowing when to have rest, when to have activity, and how much of each to have.</i>"
                (<b>Sri Sri Ravi Shankar</b>)</h2>
        </div>

        <!-- Buttons -->
        <div class="container container--home">
            
            <a href="{{ route('guest.login') }}" class="button button--primary">Sign in</a>
        

            <a href="{{ route('guest.register') }}" class="button button--secondary">Register</a>
        </div>
    </div>
</x-guest-layout>