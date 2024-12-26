   <x-guest-layout>
   <div class="flex flex--full">
            <div class="card card--full">
                <form class="form form--full" method="POST" action="{{ route('guest.login-post') }}">
                    @csrf
                    <h3 class="form__title">Login</h3>

                    <div class="form__group">
                        <label for="email" class="form__label">E-mail</label>
                        <input id="email" type="email" class="form__input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form__group">
                        <label for="password" class="form__label">Password</label>
                        <input id="password" type="password" class="form__input" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="form__error">{{ $message }}</span>
                        @enderror
                    </div>

                    

                    <div class="form__group">
                        <button type="submit" class="button button--primary button--form">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <div class="form__group form__group--links">
                        <hr class="form__hr">
                        <span class="form__or">or</span>
                        <hr class="form__hr">
                    </div>

                    <div class="form__group form__group--links">
                        
                        <a href="{{ route('guest.register') }}" class="form__link">Signup</a>
             
                    </div>

                   <h4 class="form__logo">RestApp</h4>

                </form>
            </div>
        </div>
    </div>
</x-guest-layout>